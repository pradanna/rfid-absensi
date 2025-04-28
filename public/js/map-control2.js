var map_container;
var map_container_single;
var center_indonesia = {
    lat: -0.4029326, lng: 110.5938779
};
var s_provinsi = '';
var s_kota = '';
var s_tipe = '';
var s_posisi = '';

function initMap() {
    const myLatLng = {lat: -7.5589494045543475, lng: 110.85658809673708};
    map_container = new google.maps.Map(document.getElementById("main-map"), {
        zoom: 11,
        center: myLatLng,
    });


    generateGoogleMapData()
}

async function generateGoogleMapData() {
    try {
        // Tampilkan loading dan set progres awal
        $('#loading').show();
        let progressBar = $('#progress-bar');
        let progress = 0;

        // Update progress bar secara berkala
        let interval = setInterval(() => {
            if (progress < 90) { // Batasi hingga 90% sementara menunggu data dari server
                progress += 10;
                progressBar.css('width', progress + '%');
                progressBar.text(progress + '%');
            }
        }, 300); // Update setiap 300ms

        // Request data
        let response = await $.get('/map/data?province=' + s_provinsi + '&city=' + s_kota + '&type=' + s_tipe + '&position=' + s_posisi);
        let payload = response['payload'];

        // Setelah data didapatkan, set progress ke 100% dan sembunyikan
        clearInterval(interval);
        progressBar.css('width', '100%').text('100%');

        // Filter payload untuk hanya koordinat yang berada di Indonesia
        let filteredPayload = payload.filter(item => {
            let latitude = item.latitude;
            let longitude = item.longitude;
            return latitude >= -11.0 && latitude <= 6.1 && longitude >= 95.0 && longitude <= 141.0;
        });

        // Lanjutkan pemrosesan data hanya dengan koordinat yang valid
        removeMultiMarker();
        if (filteredPayload.length > 0) {
            currentPage = 1;
            createGoogleMapMarker(filteredPayload);
            updateListTitik(filteredPayload);
        }

    } catch (e) {
        console.log(e);
    } finally {
        // Sembunyikan loading setelah selesai
        setTimeout(() => $('#loading').hide(), 500); // Delay sedikit agar 100% terlihat
    }
}


let currentPage = 1;
const itemsPerPage = 12;
function updateListTitik(titik) {
    const listTitikContainer = $('.list-titik');
    listTitikContainer.empty(); // Kosongkan kontainer sebelum menambahkan data

    // Hitung total halaman
    const totalItems = titik.length;
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    const start = (currentPage - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    const paginatedItems = titik.slice(start, end); // Ambil item untuk halaman saat ini

    // Loop melalui setiap item dan tambahkan ke kontainer
    paginatedItems.forEach(function(d) {
        listTitikContainer.append(`
            <a class="card-article" href="/listing/${d.slug}">
                <img src="http://internal.yousee-indonesia.com${d.image2}" />
                <div style="position: absolute; top: 50%; right: 0; transform: translateY(-50%); background-color: green; padding: 2px 10px; border-radius: 5px 0 0 5px; font-size: 0.8rem; color: white;">
                    ${d.type.name}
                </div>
                <div class="article-content">
                    <div class="article-wrapper">
                        <p class="title mt-2">${d.city.province.name}</p>
                        <p class="time">${d.city.name}</p>
                        <p class="alamat">${d.address}</p>
                        <hr>
                    </div>
                </div>
            </a>
        `);
    });

    // Tambahkan navigasi pagination
    const paginationContainer = $('#pagination');
    paginationContainer.empty(); // Kosongkan navigasi pagination sebelumnya

    // Tambahkan tombol Prev
    if (currentPage > 1) {
        paginationContainer.append(`<a href="#" class="prev-next" id="prev-page">Prev</a>`);
    }

    const isMobile = window.innerWidth <= 540;



    // Hitung halaman yang ditampilkan
    isMobile ? pageStart = Math.max(1, currentPage - 2) : pageStart = Math.max(1, currentPage - 4); // Mulai dari halaman 1 atau currentPage-4
    isMobile ? pageEnd = Math.min(totalPages, pageStart + 2) : pageEnd = Math.min(totalPages, pageStart + 4); // Akhiri di totalPages atau pageStart+8

    // Loop untuk menampilkan angka halaman
    for (let i = pageStart; i <= pageEnd; i++) {
        const pageItem = $(`<a href="#" class="page-link ${i === currentPage ? 'active' : ''}">${i}</a>`);
        pageItem.on('click', function(e) {
            e.preventDefault();
            currentPage = i; // Set halaman saat ini
            updateListTitik(titik); // Update tampilan dengan item yang sesuai
        });
        paginationContainer.append(pageItem);
    }

    // Tambahkan tombol Next
    if (currentPage < totalPages) {
        paginationContainer.append(`<a href="#" class="prev-next" id="next-page">Next</a>`);
    }

    // Event listener untuk tombol Prev
    $('#prev-page').on('click', function(e) {
        e.preventDefault();
        if (currentPage > 1) {
            currentPage--; // Kurangi halaman saat ini
            updateListTitik(titik); // Update tampilan
        }
    });

    // Event listener untuk tombol Next
    $('#next-page').on('click', function(e) {
        e.preventDefault();
        if (currentPage < totalPages) {
            currentPage++; // Tambah halaman saat ini
            updateListTitik(titik); // Update tampilan
        }
    });
}


var multi_marker = [];

function removeMultiMarker() {
    for (i = 0; i < multi_marker.length; i++) {
        multi_marker[i].setMap(null);
    }
}

function createGoogleMapMarker(payload = []) {
    return new Promise((resolve, reject) => {
        var bounds = new google.maps.LatLngBounds();

        payload.forEach(function (v, k) {
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(v['latitude'], v['longitude']),
                map: map_container,
                icon: v['type']['icon'],
                title: v['name'],
            });

            multi_marker.push(marker);

            let infowindow = new google.maps.InfoWindow({
                content: windowContent(v, k, "vendor"),
            });

            marker.addListener('click', function () {
                infowindow.open({
                    anchor: marker,
                    map: map_container,
                    shouldFocus: false,
                });
            });

            bounds.extend(marker.position);
        });

        // Setelah semua marker ditambahkan, sesuaikan tampilan peta
        map_container.fitBounds(bounds);

        // Resolve promise setelah semua marker selesai ditambahkan
        resolve();
    });
}


function windowContent(data, key, role = 'presence') {

    return '<div class="d-flex flex-column">' +
        '<p class="fw-bold">' + data['location'] + '</p>' +
        '<p>' + data['address'] + '</p>'  +
        '<a  href="/listing/'+data['slug']+'" style="font-size: 10px;" class="btn-detail-item" data-id="' + data['id'] + '">Lihat Detail</a>' +
        '</div>';

}

async function openDetail(element) {
    event.preventDefault()
    let id = element.dataset.id;
    await generateSingleGoogleMapData(id);
    $('#simple-modal-detail').modal('show');
}

async function generateSingleGoogleMapData(id) {
    try {
        let payload = id;
        if (typeof id == 'string'){
            let response = await $.get('/map/data/' + id);
            payload = response.payload;
        }else{
            const url = await getUrl(id.id);
            payload.url = url;
        }

        const location = {lat: payload['latitude'], lng: payload['longitude']};
        map_container_single = new google.maps.Map(document.getElementById("single-map-container"), {
            zoom: 16,
            center: location,
        });
        new google.maps.Marker({
            position: new google.maps.LatLng(payload['latitude'], payload['longitude']),
            map: map_container_single,
            icon: payload['type']['icon'],
            title: payload['name'],
        });
        generateDetail(payload);
    } catch (e) {
        console.log(e);
    }
}

function generateDetail(data) {
    $('#detail-title-tipe').html(data['type']['name']);
    $('#detail-title-nama').html('( ' + data['name'] + ' )');
    // $('#single-map-container-street-view').html(data['url']);
    $('#detail-vendor').val(data['vendor_all']['name']+' ('+data['vendor_all']['brand']+')');
    $('#detail-vendor-address').val(data['vendor_all']['address']);
    $('#detail-vendor-email').val(data['vendor_all']['email']);
    $('#detail-vendor-phone').val(data['vendor_all']['picPhone']);
    $('#detail-vendor-phone-pic').val(data['vendor_all']['picPhone']);
    $('#detail-vendor-pic').val(data['vendor_all']['picName']);
    $('#detail-provinsi').val(data['city']['province']['name']);
    $('#detail-kota').val(data['city']['name']);
    $('#detail-alamat').val(data['address']);
    $('#detail-lokasi').val(data['location']);
    $('#detail-coordinate').val(data['latitude'] + ', ' + data['longitude']);
    $('#detail-tipe').val(data['type']['name']);
    $('#detail-posisi').val(data['position']);
    $('#detail-panjang').val(data['height']);
    $('#detail-lebar').val(data['width']);
    $('#detail-qty').val(data['qty']);
    $('#detail-side').val(data['side']);
    $('#detail-trafic').val(data['trafic']);
    $('#single-map-container-street-view').html(data['url']);
    $('#detail-gambar-1').attr('src', data['image1']);
    $('#detail-gambar-2').attr('src', data['image2']);
    $('#detail-gambar-3').attr('src', data['image3']);
    $('#link-gbr1').attr('href', data['image3']);
    $('#dwnld-gbr1').attr('href', data['image3']);
    $('#dwnld-gbr1').attr('download', data['image3']);
    $('#link-gbr2').attr('href', data['image3']);
    $('#dwnld-gbr2').attr('href', data['image3']);
    $('#dwnld-gbr2').attr('download', data['image3']);
    $('#link-gbr3').attr('href', data['image3']);
    $('#dwnld-gbr3').attr('href', data['image3']);
    $('#dwnld-gbr3').attr('download', data['image3']);

    let picPhone = data['vendor_all']['picPhone'];
    let splitNumber = picPhone.split('/')
    let num = splitNumber[0].split(' ').join('')
    const first = num.substring(0, 1);
    if (first == 0){
        num = '62'+num.substring(1)
    }
    console.log('firstfirstfirst',first)
    console.log('2222222222',num)
    // console.log(window.location.hostname);
    // const img = data['image1'];
    //
    // navigator.clipboard.writeText(copyText.value);
    const text = 'Apakah '+data['type']['name']+' yang berlokasi di '+data['city']['name']+' '+data['address']+' '+data['location']+' tersedia ?';
    $('.sendWa').attr('href','https://wa.me/'+num+'?text='+encodeURI(text)).attr('target','_blank')
}

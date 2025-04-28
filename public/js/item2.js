let image1, image2, image3;
var s_provinsi = localStorage.getItem('s_provinsi') || null;
var s_kota = localStorage.getItem('s_kota') || null;
var s_tipe = localStorage.getItem('s_tipe') || null;
var s_posisi = localStorage.getItem('s_posisi') || null;

var t_provinsi = localStorage.getItem('t_provinsi') || null;
var t_kota = localStorage.getItem('t_kota') || null;
var t_tipe = localStorage.getItem('t_tipe') || null;
var t_posisi = localStorage.getItem('t_posisi') || null;


var center = {
  lat: -7.57797433093528,
  lng: 110.80924297710521,
};

function onTabChange() {
  $("#pills-tab").on("shown.bs.tab", function (e) {
    if (e.target.id === "pills-peta-tab") {
      // generateMap("main-map");
      generateGoogleMapData().then((r) => {});
    }
  });
}

function onTabDetailChange() {
  $("#pills-tab-detail").on("shown.bs.tab", function (e) {
    if (e.target.id === "pills-maps-tab-detail") {
      let id = $("#d-id").val();
      // generateSingleMap("map-detail", id);
    }
  });
}

$(document).on("change", "#province", function () {
  let id = $(this).val();
  getSelect(
    "city",
    "/data/province/" + id + "/city",
    "name",
    null,
    "Pilih Kota"
  );
});

$(document).on("change", "#f-provinsi", function (ev) {
    localStorage.setItem('s_provinsi', $(this).val());

  if ( localStorage.getItem('s_provinsi') === "") {
    getSelect("f-kota", "/data/city", "name", null, window.translations.semua_kota);
  } else {
    getSelect(
      "f-kota",
      "/data/province/" +  localStorage.getItem('s_provinsi') + "/city",
      "name",
      null,
      window.translations.semua_kota
    );
  }
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  localStorage.setItem('t_provinsi', text);
  pillSearch("provinsi", localStorage.getItem('t_provinsi'));
  localStorage.setItem('t_kota', '');
  localStorage.setItem('s_kota', '');
  pillSearch("kota", localStorage.getItem('t_kota'));
  datatableItem();
  generateGoogleMapData().then((r) => {});
});
$(document).on("change", "#f-kota", function (ev) {
  localStorage.setItem('s_kota', $(this).val());
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  localStorage.setItem('t_kota', text);
  pillSearch("kota", localStorage.getItem('t_kota'));
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

$(document).on("change", "#f-tipe", function (ev) {
  localStorage.setItem('s_tipe', $(this).val());
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  localStorage.setItem('t_tipe', text);
  pillSearch("tipe", localStorage.getItem('t_tipe'));
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

$(document).on("change", "#f-posisi", function (ev) {
  localStorage.setItem('s_posisi', $(this).val());
  let text = ev.currentTarget.options[ev.currentTarget.selectedIndex].text;
  localStorage.setItem('t_posisi', text);
  pillSearch("posisi", localStorage.getItem('t_posisi'));
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

function pillSearch(a, text) {
  let pill = $("#pillSearch");
  let child = document.getElementById("pill" + a);
  if (child) {
    $("#pill" + a + " #text").html(text);
  } else {
    pill.append(
      '<span class="pill " id="pill' +
        a +
        '" style="border-radius: 200px; align-items: center"><span id="text" class="me-2">' +
        text +
        '</span>  <a role="button" id="removePill" data-id="' +
        a +
        '"><i class="material-symbols-outlined " style="font-size: 12px">close</i></a></span>'
    );
  }
  //
}

$(document).on("change", ".selectType", function (ev) {
  var text = $(this).find(":selected").text();
  changeSelectType(text);
});

function changeSelectType(text) {
  // $('#form #qty').removeAttr('readonly');
  $("#form #qty").val("1");
  if (text.toLowerCase().includes("led banneer") == false) {
    // $('#form #qty').val('1');
    // $('#form #qty').attr('readonly', '').val('1');
  }
}

$(document).on("click", "#removePill", function () {
  let id = $(this).data("id");
  let parent = document.getElementById("pillSearch");
  let child = document.getElementById("pill" + id);
  parent.removeChild(child);
  $("#f-" + id).val("");
  window["s_" + id] = "";
  localStorage.setItem('s_' + id, '');
  localStorage.setItem('t_' + id, null);
  datatableItem();
  generateGoogleMapData().then((r) => {});
});

$(document).on("click", "#addData, #editData", async function () {
  let id = $(this).data("id");
  let data = $(this).data("row");
  $("#form #id").val(id);
  $('#form input[type="text"]').val("");
  $('#form input[type="number"]').val("");
  // $('#form #qty').val("1").attr('readonly','');
  $("#form #qty").val("1");
  $("#form #side").val("1");
  $("#form #trafic").val("0");
  $("#form select").val("");
  let fileImg1 = null,
    fileImg2 = null,
    fileImg3 = null,
    prov = null,
    vendor = null;
  $("#city").empty();
  if (id) {
    let url = await getUrl(data.id);
    changeSelectType(data.type.name);
    prov = data.city.province.id;
    vendor = data.vendor_all?.id;
    $("#form #name").val(data.name);
    $("#form #address").val(data.address);
    $("#form #location").val(data.location);
    $("#form #url_show").val(data.url_show);
    $("#form #urlstreetview").val(url);
    $("#form #latlong").val(data.latitude + ", " + data.longitude);
    $("#form #position").val(data.position);
    $("#form #type").val(data.type.id);
    $("#form #qty").val(data.qty);
    $("#form #side").val(data.side);
    $("#form #trafic").val(data.trafic);
    $("#form #height").val(data.height);
    $("#form #width").val(data.width);
    getSelect(
      "city",
      "/data/province/" + data.city.province.id + "/city",
      "name",
      data.city.id
    );

    fileImg1 = data.image1;
    fileImg2 = data.image2;
    fileImg3 = data.image3;
  }
  getSelect("province", "/data/province", "name", prov, "Pilih Provinsi");
  getSelect("vendor", "/admin/vendor/all", "name", vendor, "Pilih Vendor");

  setImgDropify("image1", null, fileImg1);
  setImgDropify("image2", null, fileImg2);
  setImgDropify("image3", null, fileImg3);
  $("#modaltambahtitik").modal({ backdrop: "static", keyboard: false });
  $("#modaltambahtitik").modal("show");
});

$("#modaldetail").on("shown.bs.modal", function () {
  $("#pills-detail-tab").tab("show");
  onTabDetailChange();
});

$("#modaldetail").on("show.bs.modal", function () {
  $("#pills-detail-tab").tab("show");
});

$("#modaldetail").on("hidden.bs.modal", function () {});

$(document).on("click", "#detailData", async function () {
  let id = $(this).data("id");

  await generateSingleGoogleMapData(id.toString());
  $("#simple-modal-detail").modal("show");

});

function datatableItem() {
  let formData = {
    province: s_provinsi,
    city: s_kota,
    type: s_tipe,
    position: s_posisi,
  };


}

$(document).on("click", "#changeShow", function () {
  console.log("asdas");

  let form = {
    id: $(this).data("id"),
    _token: $('meta[name="_token"]').attr("content"),
  };
  $.post("/data/item/show-data", form, function (res) {
    $("#table_id").DataTable().ajax.reload(null, false);
  });
});

$(document).on("click", "#deteleData", function () {
  let row = $(this).data("row");
  let id = row.id;
  let type = row.type.name;
  let area = row.city.name;
  let address = row.address;
  let location = row.location;
  let name = type + " " + area + ", " + address + " ( " + location + " )";
  let data = {
    _token: $('meta[name="_token"]').attr("content"),
  };
  deleteData(name, "/data/item/delete/" + id, data, datatableItem);
  return false;
});

function datatableItemPresence() {
  let formData = {
    province: s_provinsi,
    city: s_kota,
    type: s_tipe,
    position: s_posisi,
  };
  let stringData = JSON.stringify(formData);
  var url = "/data/item/datatable";
  $("#table_presence").DataTable({
    destroy: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: url,
      data: formData,
    },
    fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
      // debugger;
      var numStart = this.fnPagingInfo().iStart;
      var index = numStart + iDisplayIndexFull + 1;
      // var index = iDisplayIndexFull + 1;
      $("td:first", nRow).html(index);
      return nRow;
    },
    columns: [
      {
        className: "",
        orderable: false,
        defaultContent: "",
      },
      {
        data: "city.name",
        name: "city.name",
      },
      {
        data: "name",
        name: "name",
      },
      {
        data: "address",
        name: "address",
      },
      {
        data: "height",
        name: "height",
      },
      {
        data: "width",
        name: "width",
      },
      {
        data: "type.name",
        name: "type.name",
      },
      {
        data: "qty",
        name: "qty",
      },
      {
        data: "side",
        name: "side",
      },
      {
        data: "position",
        name: "position",
      },
      {
        data: "status_rent",
        name: "status_rent",
        render: function (data, x, row) {
          if (data == 1) {
            const rent = moment(row.rent_until).format("DD MMM YYYY");
            return (
              '<span class="text-warning fw-bold">Akan disewa tanggal ' +
              rent +
              "</span>"
            );
          } else if (data == 2) {
            return '<span class="text-danger fw-bold">Disewa</span>';
          } else {
            return '<span class="text-success fw-bold">Tersedia</span>';
          }
        },
      },
      {
        data: "id",
        render: function (data, type, row) {
          delete row["url"];
          let string = JSON.stringify(row);
          return (
            "<div class='d-flex'><a class='btn-utama-soft sml rnd me-1' data-id='" +
            data +
            "' data-row='" +
            string +
            "'  \n" +
            "                                                  id='detailData'> <i class='material-symbols-outlined menu-icon'>map</i></a>\n" +
            "                                </div>"
          );
        },
      },
    ],
  });
}

function saveItem() {
  let form = $("#form");
  form.submit(async function (e) {
    e.preventDefault(e);
    let formData = new FormData(this);
    // if ($('#image1').val()) {
    //     let img = await handleImageUpload($('#image1'));
    //     formData.append('image1', img, img.name)
    // }
    // if ($('#image2').val()) {
    //     let img = await handleImageUpload($('#image2'));
    //     formData.append('image2', img, img.name)
    // }
    // if ($('#image3').val()) {
    //     let img = await handleImageUpload($('#image3'));
    //     formData.append('image3', img, img.name)
    // }
    let data = {
      form_data: formData,
      image: {
        image1: "image1",
        image2: "image2",
        image3: "image3",
      },
    };
    saveDataAjaxWImage(
      "Simpan Data",
      "form",
      data,
      "/data/item/post-item",
      afterSave
    );
    return false;
  });
}

function afterSave() {
  $("#modaltambahtitik").modal("hide");
  datatableItem();
}

$(document).on("click", "#btnHistory", function () {
  var id = $(this).data("id");
  var name = $(this).data("name");
  let tabel = $("#bodyHistory");
  tabel.empty();
  $.get("/admin/history/" + id, function (data) {
    if (data.length > 0) {
      $.each(data, function (k, v) {
        let string =
          k === parseInt(data.length - 1)
            ? v.user.nama + " ( create )"
            : v.user.nama;
        moment.locale("id");

        tabel.append(
          "<tr>" +
            "             <td>" +
            parseInt(k + 1) +
            "</td>" +
            "             <td>" +
            string +
            "</td>" +
            "             <td>" +
            moment(v.created_at).format("LLLL") +
            "</td>" +
            "         </tr>"
        );
      });
    }
  });

  $("#modalHistory #titleHistory").html(name);
  $("#modalHistory").modal("show");
});

async function showStreetView(url) {
  var panel = $("#panel-street");
  panel.empty();

  // var url = await getUrl(id);
  // if (url) {
  panel.html(url);
  let frame = $("#panel-street iframe")[0];
  if (frame) {
    $("#panel-street iframe").removeAttr("width").attr("width", "100%");
  }
  // }
}

async function getUrl(id) {
  let url;
  await $.get("/data/item/url-street-view/" + id, function (data) {
    url = data;
  });
  return url;
}

// Ambil data keranjang dari session Laravel
// Mengambil data keranjang dari session dan mengonversinya ke format JavaScript


$(document).ready(function () {
    $.ajax({
        url: "/get-cart-items", // URL yang sudah dibuat di route
        method: "GET",
        success: function (response) {
            // Pastikan response adalah objek yang valid
            if (response && Object.keys(response).length > 0) {
                displayCartItems(response);
            } else {
                console.log("Keranjang kosong.");
                displayCartItems({});
            }
        },
        error: function (error) {
            console.error("Terjadi kesalahan:", error);
        },
    });
});

function updateCartBadge(cartItems) {
    const cartBadge = document.getElementById("cartBadge");
    if (cartItems && Object.keys(cartItems).length > 0) {
        cartBadge.textContent = Object.keys(cartItems).length;
    } else {
        cartBadge.textContent = "";
    }
}

function displayCartItems(cartItems) {
    const cartList = document.getElementById("cartItems");
    const checkoutButtonContainer = document.getElementById("checkoutButtonContainer"); // Elemen untuk menampilkan tombol checkout

    // Kosongkan daftar item cart sebelumnya
    cartList.innerHTML = '';

    // Pastikan cartItems adalah objek yang valid
    if (cartItems && Object.keys(cartItems).length > 0) {
        let message = "Halo saya mau pesan titik ini:\n\n";

        // Iterasi item yang diterima
        Object.values(cartItems).forEach((item) => {
            const listItem = document.createElement("li");
            listItem.className = "cart-item";  // Tambahkan kelas untuk flexbox

            // Membuat elemen <a>
            const link = document.createElement("a");
            link.href = `https://yousee-indonesia.com/listing/${item.slug}`;
            link.textContent = item.address;
            link.className = "cart-item-address";  // Kelas untuk styling alamat

            // Membuat tombol hapus
            const deleteButton = document.createElement("button");
            deleteButton.textContent = "✖";
            deleteButton.className = "cart-item-delete";
            deleteButton.onclick = () => removeFromCart(item.id);

            // Menambahkan elemen <a> dan tombol hapus ke dalam <li>
            listItem.appendChild(link);
            listItem.appendChild(deleteButton);

            // Menambahkan <li> ke dalam cartList
            cartList.appendChild(listItem);

            // Menambahkan item ke dalam pesan WhatsApp
            message += `- ${item.address} (https://yousee-indonesia.com/listing/${item.slug})\n`;
        });

        // Menampilkan tombol checkout
        const checkoutButton = document.createElement("button");
        checkoutButton.textContent = window.translations.tanya_ketersediaan_titik;
        checkoutButton.className = "checkout-button";
        checkoutButton.onclick = () => {
            const whatsappLink = `https://wa.me/6281393700771?text=${encodeURIComponent(message)}`;
            window.open(whatsappLink, "_blank");
        };

        checkoutButtonContainer.innerHTML = '';  // Kosongkan sebelumnya
        checkoutButtonContainer.appendChild(checkoutButton);

        updateCartBadge(cartItems);
    } else {
        // Tampilkan pesan jika keranjang kosong
        const emptyMessage = document.createElement("li");
        emptyMessage.textContent = window.translations.keranjang_kosong;
        cartList.appendChild(emptyMessage);

        // Sembunyikan tombol checkout jika keranjang kosong
        checkoutButtonContainer.innerHTML = '';
        updateCartBadge(cartItems);
    }
}


function toggleCart() {
    const cartSidebar = document.getElementById("cartSidebar");
    const cartButton = document.querySelector(".cart-button");
    const wa = document.querySelector(".whatsapp-float ");
    cartSidebar.classList.toggle("open");

    if (cartSidebar.classList.contains("open")) {
        cartButton.classList.add("shift-left");
        wa.classList.add("shift-left");
    } else {
        cartButton.classList.remove("shift-left");
        wa.classList.remove("shift-left");
    }

}

function closeCart() {
    const cartSidebar = document.getElementById("cartSidebar");
    const cartButton = document.querySelector(".cart-button");
    const wa = document.querySelector(".whatsapp-float ");
    cartSidebar.classList.remove("open");
    cartButton.classList.remove("shift-left");
    wa.classList.remove("shift-left");
}

function addToCart(id, address, slug) {
    // Ambil CSRF Token dari meta tag
    var token = $('meta[name="csrf-token"]').attr("content");

    // Kirim permintaan AJAX
    $.ajax({
        url: "/add-to-cart",
        type: "POST",
        data: {
            _token: token, // Sertakan token CSRF di sini
            id: id,
            address: address,
            slug: slug,
        },
        success: function (response) {
            if (response.message) {
                alert(response.message);
            }
            displayCartItems(response.cart);
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat menambah item ke keranjang.");
        },
    });
}

// Fungsi untuk memperbarui tampilan keranjang

function removeFromCart(itemId) {
    // Kirim permintaan AJAX untuk menghapus item dari keranjang
    $.ajax({
        url: "/remove-from-cart",
        type: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
            id: itemId,
        },
        success: function (response) {
            // Setelah berhasil menghapus, perbarui tampilan keranjang
            if (response.cart) {
                displayCartItems(response.cart); // Panggil kembali fungsi untuk memperbarui tampilan
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan saat menghapus item.");
        },
    });
}

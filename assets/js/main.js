document.addEventListener('DOMContentLoaded', function () {

    // 1. Notifikasi (flash message) hilang sendiri setelah beberapa detik
    document.querySelectorAll('.alert').forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .5s, transform .5s';
            el.style.opacity = '0';
            el.style.transform = 'translateY(-6px)';
            setTimeout(function () { el.remove(); }, 500);
        }, 4500);
    });

    // 2. Preview foto produk saat memilih file di form tambah / edit
    var input = document.getElementById('gambar');

    if (input) {
        var box  = document.createElement('div');
        var img  = document.createElement('img');
        var info = document.createElement('small');
        var urlSekarang = null;

        box.className = 'preview-gambar';
        box.hidden = true;
        img.alt = 'Pratinjau foto';
        box.appendChild(img);
        box.appendChild(info);
        input.parentNode.appendChild(box);

        input.addEventListener('change', function () {
            // Bersihkan preview sebelumnya
            if (urlSekarang) {
                URL.revokeObjectURL(urlSekarang);
                urlSekarang = null;
            }

            var file = input.files[0];
            if (!file || file.type.indexOf('image/') !== 0) {
                box.hidden = true;
                return;
            }

            var batas = 2 * 1024 * 1024; // 2 MB, sama dengan aturan di server
            var mb    = (file.size / 1048576).toFixed(2);

            urlSekarang = URL.createObjectURL(file);
            img.src = urlSekarang;

            if (file.size > batas) {
                info.textContent = file.name + ' (' + mb + ' MB) - melebihi 2 MB, akan ditolak.';
                info.className = 'over';
            } else {
                info.textContent = file.name + ' (' + mb + ' MB)';
                info.className = '';
            }
            box.hidden = false;
        });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const photoDetailsModal = document.getElementById('photoDetailsModal');
    
    if (photoDetailsModal) {
        photoDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Button that triggered the modal
            
            // Safeguard in case button or attributes are not available
            if (!button) return;

            const title = button.getAttribute('data-title') || 'No Title';
            const description = button.getAttribute('data-description') || 'No Description';
            const date = button.getAttribute('data-date') || 'Unknown Date';
            const username = button.getAttribute('data-username') || 'Anonymous';
            const likes = button.getAttribute('data-likes') || '0';
            const comments = button.getAttribute('data-comments') || '0';

            // Update modal content
            document.getElementById('JudulFoto').textContent = judul;
            document.getElementById('DeskripsiFoto').textContent = deskripsi;
            document.getElementById('TanggalUnggah').textContent = tanggal_unggah;
            document.getElementById('Username').textContent = username;
            document.getElementById('jumlah_like').textContent = like;
            document.getElementById('jumlah_komentar').textContent = komentar;
        });
    }
});

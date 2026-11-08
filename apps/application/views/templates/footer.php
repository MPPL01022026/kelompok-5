            </div> <!-- /.content-body -->
        </main> <!-- /.main-content -->
    </div> <!-- /.layout -->

    <script>
    // Mobile sidebar toggle
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() { alert.remove(); }, 300);
        }, 5000);
    });

    // Modal functions
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
    }

    // Close modal on backdrop click
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // Number formatting
    function formatCurrency(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    // Confirm delete
    function confirmDelete(url, itemName) {
        if (confirm('Apakah Anda yakin ingin menghapus ' + (itemName || 'data ini') + '?')) {
            window.location.href = url;
        }
    }
    </script>
</body>
</html>

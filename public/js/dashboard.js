function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}

function toggleRekap() {
    document.getElementById('rekapItem').classList.toggle('open');
}

function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function(e) {
    const profile = document.getElementById('profileMenu');

    if (!profile) return; // 🔥 penting

    if (!e.target.closest('.profile')) {
        profile.style.display = 'none';
    }
});


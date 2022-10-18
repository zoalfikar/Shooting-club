if (sessionStorage.expanded === 'true') {
    document.getElementById('sidebar').style.width = 'var(--sidebar-width)';
} else {
    document.getElementById('sidebar').style.width = 'calc(2rem + 32px)'
}
document.addEventListener('sidebarStatusChanged', (e) => {
    if (sessionStorage.expanded === 'true') {
        document.getElementById('sidebar').style.width = 'var(--sidebar-width)';
    } else {
        document.getElementById('sidebar').style.width = 'calc(2rem + 32px)'
    }
});

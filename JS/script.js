
document.addEventListener('mousemove', function(e) {
    const hero = document.getElementById('hero');
    const x = e.clientX / window.innerWidth - 0.5;
    const y = e.clientY / window.innerHeight - 0.5;
    hero.style.backgroundPosition = `${50 - 5 * x}% ${50 - 5 * y}%`;
});

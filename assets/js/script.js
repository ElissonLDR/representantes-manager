document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('rm-search');
    const cards = document.querySelectorAll('.rm-card');
    const sidebarItems = document.querySelectorAll('.rm-sidebar-item');

    // BUSCA
    if (input) {
        input.addEventListener('keyup', function () {

            const value = this.value.toLowerCase();

            cards.forEach(card => {

                const nome = card.querySelector('h3')?.innerText.toLowerCase() || '';
                const cidades = card.getAttribute('data-cidades')?.toLowerCase() || '';

                card.style.display = (nome.includes(value) || cidades.includes(value)) ? 'block' : 'none';
            });
        });
    }

    // CLICK SIDEBAR (filtro por cidade)
    sidebarItems.forEach(item => {

        item.addEventListener('click', function () {

            const cidade = this.querySelector('.rm-cidade').innerText.toLowerCase();

            cards.forEach(card => {

                const cidades = card.getAttribute('data-cidades')?.toLowerCase() || '';

                card.style.display = cidades.includes(cidade) ? 'block' : 'none';
            });
        });
    });

});
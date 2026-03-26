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

<<<<<<< HEAD
});

document.addEventListener("click", function(e){

    // MODAL
    if(e.target.classList.contains("rm-ver-cidades")){
        const card = e.target.closest(".rm-card");
        const cidades = card.dataset.cidades.split(',');

        document.getElementById("rm-modal-cidades").innerText = cidades;
        document.getElementById("rm-modal").style.display = "block";
    }

    if(e.target.classList.contains("rm-close")){
        document.getElementById("rm-modal").style.display = "none";
    }

    // SIDEBAR
    if(e.target.closest(".rm-sidebar-item")){
        const item = e.target.closest(".rm-sidebar-item");
        const id = item.dataset.id;

        document.querySelectorAll(".rm-sidebar-item").forEach(i => i.classList.remove("active"));
        item.classList.add("active");

        if(id === "all"){
            document.querySelectorAll(".rm-card").forEach(c => c.style.display = "block");
            return;
        }

        document.querySelectorAll(".rm-card").forEach(card => {
            const cidades = card.dataset.cidades.split(',');

            if(cidades.includes(id)){
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
=======
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
>>>>>>> d5ae31fde395fecd55b176c5367858ed25209432

});
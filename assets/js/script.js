document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('rm-search');
    const cards = document.querySelectorAll('.rm-card');
    const sidebarItems = document.querySelectorAll('.rm-sidebar-item');

    // BUSCA
    if (input) {
        input.addEventListener('keyup', function () {

            const value = input.value.toLowerCase();

            cards.forEach(card => {

                const nome = card.querySelector('h3')?.innerText.toLowerCase() || '';
                const cidadesTexto = card.querySelector('.rm-cidades')?.innerText.toLowerCase() || '';

                const telefones = [...card.querySelectorAll('.rm-telefone')]
                .map(t => t.innerText.toLowerCase())
                .join(' ');
            
                const match =
                    nome.includes(value) ||
                    cidadesTexto.includes(value) ||
                    telefones.includes(value);
                
                card.style.display = match ? 'block' : 'none';
            });

            const visibleCards = [...cards].filter(card => card.style.display !== 'none');

            const titulo = document.querySelector('.rm-titulo');
            const qtd = document.querySelector('.rm-quantidade');
            
            if (value.length > 0) {
                titulo.innerText = `Representantes encontrados para "${value}"`;
            } else {
                const active = document.querySelector('.rm-sidebar-item.active .rm-cidade');
                titulo.innerText = active ? active.innerText : 'Todos';
            }
            
            qtd.innerText = `(${visibleCards.length})`;
        });
    }

});

document.addEventListener("click", function(e){

    // MODAL
    if(e.target.classList.contains("rm-ver-cidades")){
        const card = e.target.closest(".rm-card");
        const nome = card.querySelector('.rm-nome')?.innerText || '';
        const cidades = card.querySelector('.rm-cidades')?.innerText || '';
        document.getElementById("rm-modal-cidades").innerHTML = `<h3 class="rm-nome">${nome}</h3><p class="rm-modal-subtitulo">Cidades atendidas:</p>${cidades}`;
        document.getElementById("rm-modal").style.display = "flex";
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
        } else {
            document.querySelectorAll(".rm-card").forEach(card => {
                const cidades = card.dataset.cidades.split(',');

                if(cidades.includes(id)){
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
         }

        const titulo = document.querySelector('.rm-titulo');
        const qtd = document.querySelector('.rm-quantidade');
        
        const visiveis = [...document.querySelectorAll('.rm-card')]
            .filter(c => c.style.display !== 'none');
        
            const cidadeEl = item.querySelector('.rm-cidade');
            const estadoEl = item.querySelector('.rm-estado');
            
            const cidadeNome = cidadeEl ? cidadeEl.innerText : '';
            const estadoNome = estadoEl ? estadoEl.innerText : '';
            
            if(id === "all"){
                titulo.innerText = "Todos";
            } else {
                titulo.innerText = `${cidadeNome}${estadoNome}`;
            }

        qtd.innerText = `(${visiveis.length})`;
    }

});
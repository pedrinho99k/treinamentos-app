function checkElementAndReadText() {
    const element = document.getElementById('title-page');

    if (element) {
        const text = element.innerText;
        //Adiciona e remove class 'active na lista do menu lateral'
        const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');
        sideLinks.forEach(element => {
            if (element.innerText === document.getElementById('title-page').innerText) {
                element.parentElement.classList.add('active');
            }
        });
    } else {

    }
}

// Chamando a função
checkElementAndReadText();
function checkElementAndReadText2() {
    const element = document.getElementById('title-page-nav');

    if (element) {
        setTimeout(() => {
            const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');
            sideLinks.forEach(element => {
                if (element.innerText === document.getElementById('title-page-nav').innerText) {
                    element.parentElement.classList.add('active');
                }
            });
        }, 200);
    }

}
checkElementAndReadText2();




/*const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');
 
sideLinks.forEach(item => {
    const li = item.parentElement;
    item.addEventListener('click', () => {
        sideLinks.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        li.classList.add('active');
    })
});*/
/*const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');
 
sideLinks.forEach(item => {
    const li = item.parentElement;
    item.addEventListener('click', () => {
        sideLinks.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        li.classList.add('active');
 
        // Armazenar o estado no localStorage
        localStorage.setItem('activeItem', item.textContent);
    });
 
    // Restaurar o estado da classe "active" ao carregar a página
    const activeItemText = localStorage.getItem('activeItem');
    if (activeItemText === item.textContent) {
        li.classList.add('active');
    }
});*/


//Função que adiciona e remove a class 'close' no menu lateral
const menuBar = document.querySelector('.content nav .bx.bx-menu');
const sideBar = document.querySelector('.sidebar');

menuBar.addEventListener('click', () => {
    if (sideBar.classList.contains('close')) {
        sideBar.classList.remove('close');
        localStorage.setItem('sidebar', 'open');
    } else {
        sideBar.classList.add('close');
        localStorage.setItem('sidebar', 'close');
    }
})

function applySavedSideBar() {
    const savedSideBar = localStorage.getItem('sidebar');
    if (savedSideBar === 'open') {
        sideBar.classList.remove('close');
    } else {
        sideBar.classList.add('close');
    }
}

applySavedSideBar();

//Maximiza o campo de busca quando a tela for menor que 576 e for clicado
const searchBtn = document.querySelector('.content nav form .form-input button');
const searchBtnIcon = document.querySelector('.content nav form .form-input button .bx');
const searchForm = document.querySelector('.content nav form');

searchBtn.addEventListener('click', function (e) {
    if (window.innerWidth < 576) {
        e.preventDefault;
        searchForm.classList.toggle('show');
        if (searchForm.classList.contains('show')) {
            searchBtnIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchBtnIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});


//Minimiza o menu lateral caso a tela for menor que 768px, adicionando a class 'close no menu lateral'
window.addEventListener('resize', () => {
    if (window.innerWidth < 768) {
        sideBar.classList.add('close');
        localStorage.setItem('sidebar', 'close');
    } else {
        sideBar.classList.remove('close');
        localStorage.setItem('sidebar', 'open');
    }
    if (window.innerWidth > 576) {
        searchBtnIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});



//Seleciona o tema Dark ou White
const toggler = document.getElementById('theme-toggle');
const themeBtnIcon = document.querySelector('.content nav .bx');
toggler.addEventListener('change', function () {
    if (this.checked) {
        saveThemePreference();
        document.body.classList.add('dark');
        themeBtnIcon.classList.replace('bxs-brightness', 'bx-brightness');

    } else {
        saveThemePreference();
        document.body.classList.remove('dark');
        themeBtnIcon.classList.replace('bxs-brightness', 'bx-brightness');

    }
});

// Armazenar o estado no localStorage

// Função para salvar o tema selecionado pelo usuário no localStorage
function saveThemePreference() {
    const themeToggle = document.getElementById('theme-toggle');
    const theme = themeToggle.checked ? 'dark' : 'light';
    localStorage.setItem('theme', theme);
}

// Verifica se o tema foi configurado anteriormente e aplica
// o tema correto com base no valor armazenado no localStorage
function applySavedTheme() {
    const savedTheme = localStorage.getItem('theme');
    const themeToggle = document.getElementById('theme-toggle');

    if (savedTheme === 'dark') {

        document.body.classList.add('dark');
        themeToggle.checked = true;
        /*const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.style.setProperty('color', '#f6f6f9');
        });*/
        themeToggle.checked = true; // Marca o botão de alternância automaticamente
    } else {

        /*const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.style.setProperty('color', '#363949');
        });*/
        themeToggle.checked = false; // Marca o botão de alternância automaticamente
    }
}
applySavedTheme();

//Função para minimizar formularios

function documentReady(callback) {
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", callback);
    } else {
        // Se o DOM já estiver carregado, execute a função imediatamente
        callback();
    }
}

function abrirModal() {
    const modal = document.getElementById('janela-modal');
    modal.classList.add('abrir');

    modal.addEventListener('click', (e) => {
        if (e.target.id == 'fechar' || e.target.id == 'janela-modal') {
            modal.classList.remove('abrir');
        }
    })
}

function fecharModal() {
    const modal = document.getElementById('janela-modal');
    modal.classList.remove('abrir');
}


// Exemplo de uso da função minimiza formulario
$(document).ready(function () {
    const iconMinimizar = document.querySelector('.icon-minimizar');
    iconMinimizar.addEventListener('click', function (e) {
        e.preventDefault(); // Corrigindo o erro aqui
        if (iconMinimizar.classList.contains('bx-chevron-down')) {
            iconMinimizar.classList.remove('bx-chevron-down');
            iconMinimizar.classList.add('bx-chevron-up');
            $(".formulario").slideUp();
        } else if (iconMinimizar.classList.contains('bx-chevron-up')) {
            iconMinimizar.classList.remove('bx-chevron-up');
            iconMinimizar.classList.add('bx-chevron-down');
            $(".formulario").slideDown();
        }
    });

    if ($(".msg-error").text() === '') {
        $(".reminders").hide();
        $(".reminders-presenca").show();
    }

    $(".bx-plus").click(function (e) {
        e.preventDefault();
        $(".reminders").slideDown();

    });
    $(".add-new").click(function (e) {
        e.preventDefault();
        $(".reminders").slideDown();

    });

    $(".bx-x").click(function (e) {
        e.preventDefault();
        $(".reminders").slideUp();
    });

    $("input[type='text']").on('input', function () {
        $(this).val($(this).val().toUpperCase());
    });
    
});
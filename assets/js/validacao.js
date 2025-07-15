// assets/js/validacao.js
document.getElementById('formContacto').addEventListener('submit', function(e) {
  let nome = this.nome.value.trim();
  let email = this.email.value.trim();
  let mensagem = this.mensagem.value.trim();
  
  if (!nome || !email || !mensagem) {
    alert("Por favor, preencha todos os campos.");
    e.preventDefault();
  }
});
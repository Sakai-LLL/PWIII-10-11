// troca e guarda o tema (kitty / melody / kuromi)
(function () {
  var salvo = 'melody';
  try { salvo = localStorage.getItem('tema') || 'melody'; } catch (e) {}
  document.documentElement.setAttribute('data-tema', salvo);

  window.trocarTema = function (t) {
    document.documentElement.setAttribute('data-tema', t);
    try { localStorage.setItem('tema', t); } catch (e) {}
  };
})();

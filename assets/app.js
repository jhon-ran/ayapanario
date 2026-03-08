// ─────────────────────────────────────────────────────────────────
// Ayapanario — app.js
// Toda la lógica de búsqueda y renderizado de resultados.
// ─────────────────────────────────────────────────────────────────

const API = {
  buscar:     'api/buscar.php',
  categorias: 'api/categorias.php'
};

// Acceso rápido a elementos por ID
const $ = (id) => document.getElementById(id);

// Escapado de HTML para evitar XSS
const esc = (s) =>
  (s ?? '').toString().replace(/[&<>"']/g, m =>
    ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[m])
  );

// Parsea el campo de ejemplos (formato: [frase] :: traducción || ...)
function parseEjemplos(str) {
  if (!str) return [];
  return str.split('||')
    .map(x => x.trim())
    .filter(Boolean)
    .map(x => {
      const m = x.match(/^\s*\[(.*?)\]\s*::\s*(.+)\s*$/u);
      if (m) return { frase: m[1].trim(), traduccion: m[2].trim() };
      return { frase: '', traduccion: x };
    });
}

// Estado de paginación
let state = { q: '', categoria: '', page: 1, pages: 1, limit: 20, total: 0 };

// ── Carga las categorías en el selector ──────────────────────────
async function loadCategorias() {
  try {
    const r = await fetch(API.categorias);
    const j = await r.json();
    if (!j.ok) return;

    const sel = $('categoria');
    sel.innerHTML =
      `<option value="">Todas las categorías</option>` +
      j.rows.map(x =>
        `<option value="${esc(x.categoria)}">${esc(x.categoria)} (${x.n})</option>`
      ).join('');
  } catch (e) {
    // Si falla, el selector queda con "Todas las categorías"
  }
}

// ── Ejecuta la búsqueda y actualiza el DOM ───────────────────────
async function search(page = 1) {
  state.q         = $('q').value.trim();
  state.categoria = $('categoria').value || '';
  state.limit     = parseInt($('limit').value, 10) || 20;
  state.page      = page;

  const params = new URLSearchParams();
  if (state.q)         params.set('q',         state.q);
  if (state.categoria) params.set('categoria',  state.categoria);
  params.set('page',  state.page);
  params.set('limit', state.limit);

  $('results').innerHTML = '<p class="meta">Cargando…</p>';

  try {
    const r = await fetch(API.buscar + '?' + params.toString());
    const j = await r.json();

    if (!j.ok) {
      $('results').innerHTML = '<div class="card alerta-error">Error al realizar la búsqueda.</div>';
      return;
    }

    state.pages = j.pages || 1;
    state.total = j.total || 0;

    // Contador de resultados
    $('meta').textContent = `${state.total} resultado${state.total !== 1 ? 's' : ''} · Página ${state.page} de ${state.pages}`;

    if (!j.rows.length) {
      $('results').innerHTML = '<div class="sin-resultados">Sin resultados para esta búsqueda.</div>';
    } else {
      $('results').innerHTML = j.rows.map(renderCard).join('');
    }

    // Actualiza botones de paginación
    $('prev').disabled = state.page <= 1;
    $('next').disabled = state.page >= state.pages;

  } catch (e) {
    $('results').innerHTML = '<div class="card alerta-error">No se pudo conectar con el servidor.</div>';
  }
}

// ── Genera el HTML de una tarjeta de resultado ───────────────────
function renderCard(r) {
  // Solo se muestra el primer ejemplo en la lista de resultados
  const ejemplos = parseEjemplos(r.ejemplos);
  const primerEjemplo = ejemplos.slice(0, 1).map(e => `
    <div class="ejemplo">
      ${e.frase       ? `<div class="ejemplo-frase">${esc(e.frase)}</div>`       : ''}
      ${e.traduccion  ? `<div class="ejemplo-traduccion">${esc(e.traduccion)}</div>` : ''}
    </div>
  `).join('');

  // Ortografía alternativa (solo si difiere del lema)
  const ortografia = r.ortografia && r.ortografia !== r.lema
    ? ` <span class="card-ortografia">· ${esc(r.ortografia)}</span>`
    : '';

  // Metadatos: categoría y pronunciación
  const categoria   = r.categoria_gramatical
    ? `<span class="badge-cat">${esc(r.categoria_gramatical)}</span>` : '';
  const pronunciacion = r.pronunciacion
    ? `<span>${esc(r.pronunciacion)}</span>` : '';
  const meta = (categoria || pronunciacion)
    ? `<div class="card-meta">${categoria}${pronunciacion}</div>` : '';

  return `
    <article class="card">
      <h2 class="card-lema">
        <a href="ver.php?id=${r.id}">${esc(r.lema)}${ortografia}</a>
      </h2>
      ${meta}
      ${r.definicion ? `<p class="card-definicion">${esc(r.definicion)}</p>` : ''}
      ${primerEjemplo}
    </article>
  `;
}

// ── Inicialización ───────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', async () => {
  if ($('categoria')) await loadCategorias();

  $('btnBuscar')?.addEventListener('click',  () => search(1));
  $('q')?.addEventListener('keydown',        (e) => { if (e.key === 'Enter') search(1); });
  $('categoria')?.addEventListener('change', () => search(1));
  $('limit')?.addEventListener('change',     () => search(1));
  $('prev')?.addEventListener('click',       () => search(state.page - 1));
  $('next')?.addEventListener('click',       () => search(state.page + 1));

  // Carga inicial de resultados al abrir buscar.php
  if ($('results')) search(1);
});

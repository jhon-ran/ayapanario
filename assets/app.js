const API = {
  buscar: 'api/buscar.php',
  categorias: 'api/categorias.php'
};

const $ = (id) => document.getElementById(id);
const esc = (s) => (s ?? '').toString().replace(/[&<>"']/g, m => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[m]));

function parseEjemplos(str){
  if(!str) return [];
  return str.split('||').map(x=>x.trim()).filter(Boolean).map(x=>{
    const m = x.match(/^\s*\[(.*?)\]\s*::\s*(.+)\s*$/u);
    if(m) return {frase:m[1].trim(), traduccion:m[2].trim()};
    return {frase:'', traduccion:x};
  });
}

let state = { q:'', categoria:'', page:1, pages:1, limit:20, total:0 };

async function loadCategorias(){
  try{
    const r = await fetch(API.categorias);
    const j = await r.json();
    if(!j.ok) return;
    const sel = $('categoria');
    sel.innerHTML = `<option value="">Todas</option>` + j.rows.map(x =>
      `<option value="${esc(x.categoria)}">${esc(x.categoria)} (${x.n})</option>`
    ).join('');
  }catch(e){}
}

async function search(page=1){
  state.q = $('q').value.trim();
  state.categoria = $('categoria').value || '';
  state.limit = parseInt($('limit').value,10) || 20;
  state.page = page;

  const p = new URLSearchParams();
  if(state.q) p.set('q', state.q);
  if(state.categoria) p.set('categoria', state.categoria);
  p.set('page', state.page);
  p.set('limit', state.limit);

  $('results').innerHTML = 'Cargando…';

  const r = await fetch(API.buscar + '?' + p.toString());
  const j = await r.json();
  if(!j.ok){
    $('results').innerHTML = 'Error al buscar.';
    return;
  }

  state.pages = j.pages || 1;
  state.total = j.total || 0;

  $('meta').textContent = `Total: ${state.total} · Página ${state.page}/${state.pages}`;

  if(!j.rows.length){
    $('results').innerHTML = '<div class="card">Sin resultados.</div>';
    return;
  }

  $('results').innerHTML = j.rows.map(renderCard).join('');
  $('prev').disabled = state.page <= 1;
  $('next').disabled = state.page >= state.pages;
}

function renderCard(r){
  const ejs = parseEjemplos(r.ejemplos);
  const ejHtml = ejs.slice(0,1).map(e => `
    <div class="ej">
      ${e.frase ? `<div class="fr">${esc(e.frase)}</div>` : ''}
      ${e.traduccion ? `<div>${esc(e.traduccion)}</div>` : ''}
    </div>
  `).join('');

  return `
    <article class="card">
      <h3><a href="ver.php?id=${r.id}" style="text-decoration:none">${esc(r.lema)}${r.ortografia && r.ortografia!==r.lema ? ` · <span class="small">${esc(r.ortografia)}</span>`:''}</a></h3>
      <div class="small">
        ${r.categoria_gramatical ? `Cat: ${esc(r.categoria_gramatical)}`:''}
        ${r.pronunciacion ? ` · ${esc(r.pronunciacion)}`:''}
      </div>
      ${r.definicion ? `<div class="def">${esc(r.definicion)}</div>`:''}
      ${ejHtml}
    </article>
  `;
}

document.addEventListener('DOMContentLoaded', async ()=>{
  if($('categoria')) await loadCategorias();
  $('btnBuscar')?.addEventListener('click', ()=>search(1));
  $('q')?.addEventListener('keydown', (e)=>{ if(e.key==='Enter') search(1); });
  $('categoria')?.addEventListener('change', ()=>search(1));
  $('limit')?.addEventListener('change', ()=>search(1));
  $('prev')?.addEventListener('click', ()=>search(state.page-1));
  $('next')?.addEventListener('click', ()=>search(state.page+1));
  if($('results')) search(1);
});

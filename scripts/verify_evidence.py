"""Verify retained bytes and cited code patterns offline; never execute the PHP app."""
import hashlib
import json
import re
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
manifest = json.loads((ROOT / "manifest.json").read_text(encoding="utf-8"))
files = manifest["files"]
assert len(files) == 11, "Expected 11 selected raw files"
assert {x["path"] for x in files} == {
    p.relative_to(ROOT).as_posix() for p in (ROOT / "raw").rglob("*") if p.is_file()
}, "Raw tree differs from manifest"
for item in files:
    data = (ROOT / item["path"]).read_bytes()
    assert len(data) == item["bytes"], item["path"]
    assert hashlib.sha256(data).hexdigest() == item["sha256"], item["path"]

def read(rel):
    return (ROOT / "raw/chamba-juvenil" / rel).read_text(encoding="utf-8")

controller = read("application/controllers/Registro_voto.php")
model = read("application/models/Registro_voto_model.php")
browser = read("assets/js/contador.js")
view = read("application/views/principal/admin/estadistica_votos.php")
form = read("application/views/principal/admin/registro_voto.php")
assert "$total = $this->Registro_voto_model->total_votos();" in controller
match = re.search(r'"resultado"\s*=>\s*\$total->total\s*\+\s*(\d+)\s*\+\s*(\d+)', controller)
assert match is not None
terms = tuple(map(int, match.groups()))
assert terms == (273, 800)
assert "if($total_UnoPorDies->si == null) $total_UnoPorDies->si = 800;" in controller
assert "count(id) as total" in model
assert "->where('voto',\"si\")" in model
assert '->get("tbl_registro_del_voto")' in model
assert 'base_url + "Registro_voto/total_votos"' in browser
assert "document.getElementById('total_votos')" in browser
assert "registros = response.resultado;" in browser
assert "contadorElemento.innerText = registros;" in browser
assert "setInterval(actualizarContador, 20000)" in browser
assert "Total de votos" in view and 'id="total_votos"' in view
assert "¿VOTO?" in form and 'value="si"' in form and 'value="no"' in form
schema = json.loads((ROOT / "raw/psuv/graphql/psuv-elecciones-schema-v2.json").read_text(encoding="utf-8"))
mutations = [f["name"] for t in schema["data"]["__schema"]["types"] if t["name"] == "Mutation" for f in t["fields"]]
assert len(mutations) == 10 and {"setVotacion", "createAdmin"} <= set(mutations)
print("PASS: 11 raw-file lengths and SHA-256 hashes match.")
print("PASS: cited count -> addition -> display source patterns are present.")
print("PASS: separate fallback and 10 PSUV mutation names are present.")
print("Derived arithmetic illustrations (not observed election totals):")
for count in (0, 100, 10000):
    print(f"  {count:,} + {sum(terms):,} = {count + sum(terms):,}")
print("No network requests made. Recovered application was not executed.")

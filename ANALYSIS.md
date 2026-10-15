# What the retained files show

Reviewed 15 October 2026. Line references below point to the unchanged files in this repository.

## 1. A fixed 1,073 is added to a reported count

The evidence chain in Chamba Juvenil is:

1. **Count the records.** [`Registro_voto_model.php`, lines 264–272](raw/chamba-juvenil/application/models/Registro_voto_model.php#L264) selects `count(id) as total` from `tbl_registro_del_voto`, filtered to `voto = "si"`.
2. **Load that count.** [`Registro_voto.php`, line 359](raw/chamba-juvenil/application/controllers/Registro_voto.php#L359) calls the model's `total_votos()` method.
3. **Add constants.** [Line 403](raw/chamba-juvenil/application/controllers/Registro_voto.php#L403) serializes `"resultado" => $total->total + 273 + 800`. For a numeric count N reaching this expression, the returned field is N + 1,073.
4. **Request that endpoint.** [`contador.js`, lines 14–21](raw/chamba-juvenil/assets/js/contador.js#L14) posts to `Registro_voto/total_votos`.
5. **Use the returned value.** The same script assigns `response.resultado` to `registros` at [line 45](raw/chamba-juvenil/assets/js/contador.js#L45), then writes it into the `total_votos` element at [line 63](raw/chamba-juvenil/assets/js/contador.js#L63). Its interval is 20,000 milliseconds at [line 89](raw/chamba-juvenil/assets/js/contador.js#L89).
6. **Label it as a total.** [`estadistica_votos.php`, lines 359–360](raw/chamba-juvenil/application/views/principal/admin/estadistica_votos.php#L359) labels that element “Total de votos.”

| Underlying numeric count | Returned `resultado` | Difference |
| ---: | ---: | ---: |
| 0 | 1,073 | +1,073 |
| 100 | 1,173 | +1,073 |
| 10,000 | 11,073 | +1,073 |

These are arithmetic illustrations of the expression, not recovered database counts or measurements of a deployed service. The addition does not itself update database rows; it changes a reported value. It does not add another 1,073 to storage on every refresh.

## 2. A separate counter receives an 800 fallback

[`Registro_voto.php`, line 395](raw/chamba-juvenil/application/controllers/Registro_voto.php#L395):

```php
if($total_UnoPorDies->si == null) $total_UnoPorDies->si = 800;
```

This is a **loose PHP comparison** with null, not a strict null check. When that comparison matches, the `si` field is replaced with 800. The value is returned separately as `UnoPorDies` at [line 408](raw/chamba-juvenil/application/controllers/Registro_voto.php#L408). This fallback is not an additional 800 on top of the fixed 1,073 in `resultado`; they are different response fields.

## 3. Voting status is linked to identity and location fields

The form's [“¿VOTO?” yes/no field](raw/chamba-juvenil/application/views/principal/admin/registro_voto.php#L170) indicates participation tracking. The controller's [`post_registro_votos()`](raw/chamba-juvenil/application/controllers/Registro_voto.php#L87) reads fields including cédula, telephone number, voting status, voting center, latitude, and longitude. This supports a finding about the design's ability to associate people with recorded participation and location.

The release contains field definitions and program logic, **not actual people's records**. It does not establish how many real individuals were tracked, whether every field was populated, or how the records were used.

## 4. PSUV schema findings are separate

The saved [PSUV v2 introspection response](raw/psuv/graphql/psuv-elecciones-schema-v2.json) lists ten mutation names:

```
aperturaCentroVotacion
cierreCentroVotacion
createEmployee
deleteEmployeeById
aperturaMesa
cierreMesa
setVotacion
me
loginEmployee
createAdmin
```

The collection is attributed in the retained archive to `api-psuv-elecciones.guarico.gob.ve/graphql`. The included [frontend HTML](raw/psuv/frontend/index.html) is only a shell with asset references; the referenced JavaScript bundle and backend resolvers are not included.

These files establish the contents of a saved schema. They do not independently establish the authentication context of its original retrieval, whether an arbitrary caller could execute a mutation, or whether any operation was used to alter an election. Authorization may be enforced during execution or in application logic; see the official [GraphQL authorization documentation](https://www.graphql.org/learn/authorization/) and [introspection documentation](https://www.graphql.org/learn/introspection/).

No government endpoint was queried and no mutation was executed for this October 2026 review and release.

## What remains unproven

- Whether this exact Chamba source revision was deployed on a particular election date.
- Why the constants 273 and 800 were introduced, who authorized them, or whether they were intended as an adjustment, a test artifact, or deception.
- Whether the application affected official ballot counting or certified national results.
- Unauthorized execution of the PSUV schema's mutations.
- Claims that the same Chamba code was deployed on other PSUV or communes sites.
- The earlier presentation claim of 572,103 queryable PSUV voter records; this release does not substantiate that number.

The supported conclusion is specific: **the retained Chamba reporting code adds a fixed 1,073 to its underlying “yes” count and routes that value to a displayed total.** It warrants scrutiny without substituting an unproven national-election allegation for the actual evidence.

# Provenance and selection

Patrick Quirk supplied the retained research archive used for this release. The files were reviewed on 15 October 2026. Original acquisition circumstances are owner-provided provenance, not independently authenticated by this release.

## Two retained collections

| Collection | Retained archive folder | Attributed host |
| --- | --- | --- |
| Chamba Juvenil | `venezuela/venezuela-v2/VE-DUMP/registro-chambajuvenil` | `registro.chambajuvenil.gob.ve` |
| PSUV election application | `venezuela/venezuela-election-api` | `psuv-elecciones.guarico.gob.ve` / `api-psuv-elecciones.guarico.gob.ve` |

The [manifest](manifest.json) records each selected file's retained path, byte length, and SHA-256 digest. The raw file bytes are unchanged. Git text conversion is disabled for `raw/` so a checkout can reproduce those hashes.

The Chamba checkout's retained HEAD text was `b5640971f09755e2c9cda9adfec95f50f3e745a1`. Its object database was incomplete during review. This is an archival observation, **not a verified commit ancestry or deployment identifier**. Full Git history is not released.

Filesystem dates observed in the archive included March 2026 dates. Filesystem timestamps do not establish when a system was acquired, authored, or deployed. No election-date deployment assertion is made here.

## What is included

- Controller, model, and browser/view files needed to inspect the adjusted total and its displayed destination.
- The base controller and hook configuration to supply some surrounding application context. They are not a complete authorization audit.
- Two saved PSUV GraphQL schema responses and its retained frontend shell.
- Analysis, a source-based graphic, and an offline verification script authored for this release.

## What is excluded

- Actual voter, employee, contact, and other personal-record exports.
- Credential configurations, private keys, secrets, and access material.
- Unrelated archives, database dumps, third-party bundles, and incomplete Git objects.
- Earlier narrative articles whose claims are not established by the released code.

The selected source was reviewed for literal credentials and personal records, with additional pattern screening. The sample email `ex@abc.xyz` in a form placeholder is retained as template text. Code defining identity fields is not a dump of identities.

**Selection is not redaction:** included raw files are byte-for-byte copies; sensitive or irrelevant files were excluded entirely. This is not a complete, installable application or a complete PSUV source release.

Hashes establish the identity and integrity of these retained copies. They do not independently prove government origin, deployment, intent, or an effect on election results.

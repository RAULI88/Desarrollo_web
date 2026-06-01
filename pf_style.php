<style>
:root { --uas-blue:#002b5c; --uas-gold:#ffc72c; --bg:#f0f4f8; }
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Segoe UI',sans-serif;background:var(--bg);color:#333;}
.pf-header{background:var(--uas-blue);color:white;padding:20px 30px;border-bottom:4px solid var(--uas-gold);display:flex;align-items:center;gap:20px;}
.pf-header h1{font-size:1.4em;font-weight:700;}
.pf-back{color:var(--uas-gold);text-decoration:none;font-weight:bold;font-size:.9em;white-space:nowrap;}
.pf-back:hover{text-decoration:underline;}
.pf-container{max-width:1000px;margin:25px auto;padding:0 20px;display:flex;flex-direction:column;gap:20px;}
.pf-form-card,.pf-table-card{background:white;border-radius:10px;padding:25px;box-shadow:0 2px 12px rgba(0,0,0,.08);}
.pf-form-card h2,.pf-table-card h2{color:var(--uas-blue);margin-bottom:18px;font-size:1.1em;border-bottom:2px solid var(--uas-gold);padding-bottom:8px;}
.pf-field{margin-bottom:14px;}
.pf-field label{display:block;margin-bottom:5px;font-weight:600;font-size:.88em;color:#444;}
.pf-field input,.pf-field select,.pf-field textarea{width:100%;padding:9px 12px;border:1px solid #d0d7de;border-radius:6px;font-size:.92em;background:#fafafa;transition:.2s;}
.pf-field input:focus,.pf-field select:focus{outline:none;border-color:var(--uas-blue);background:white;}
.pf-row{display:grid;grid-template-columns:1fr 1fr;gap:15px;}
.pf-actions{margin-top:18px;display:flex;gap:10px;align-items:center;}
.pf-alert{background:#fff3cd;border:1px solid #ffc107;color:#856404;padding:12px;border-radius:6px;margin-bottom:15px;font-size:.9em;}
.pf-table{width:100%;border-collapse:collapse;font-size:.9em;}
.pf-table thead tr{background:var(--uas-blue);color:white;}
.pf-table th,.pf-table td{padding:10px 12px;text-align:left;border-bottom:1px solid #eee;}
.pf-table tbody tr:hover{background:#f5f8ff;}
.pf-empty{text-align:center;color:#aaa;padding:30px!important;font-style:italic;}
.pf-badge{display:inline-block;padding:3px 9px;border-radius:12px;font-size:.78em;font-weight:700;background:#e9ecef;color:#555;}
.badge-ok{background:#d4edda;color:#155724;}
.badge-warn{background:#fff3cd;color:#856404;}
.badge-no{background:#f8d7da;color:#721c24;}
.pf-btns{display:flex;gap:6px;flex-wrap:wrap;}
/* Buttons */
.btn-primary{background:var(--uas-blue);color:white;border:none;padding:9px 18px;border-radius:6px;cursor:pointer;font-weight:600;font-size:.9em;}
.btn-primary:hover{opacity:.88;}
.btn-cancel{background:#6c757d;color:white;text-decoration:none;padding:9px 15px;border-radius:6px;font-size:.88em;font-weight:600;}
.btn-edit{background:var(--uas-gold);color:#333;text-decoration:none;padding:5px 10px;border-radius:5px;font-size:.82em;font-weight:600;}
.btn-delete{background:#dc3545;color:white;text-decoration:none;padding:5px 10px;border-radius:5px;font-size:.82em;font-weight:600;}
@media(max-width:640px){.pf-row{grid-template-columns:1fr;}.pf-table{font-size:.8em;}.pf-table th,.pf-table td{padding:7px 8px;}}
</style>
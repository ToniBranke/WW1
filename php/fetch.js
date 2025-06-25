fetch('endabrechnung.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
  body: new URLSearchParams({
    'V0-7EN-07': 15.0 // 15% Gewinnaufschlag als Beispiel
  })
})
.then(res => res.json())
.then(data => {
  console.log("Endabrechnung:", data.endabrechnung);
});
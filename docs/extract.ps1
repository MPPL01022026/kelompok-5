$word = New-Object -ComObject Word.Application
$word.Visible = $false
$doc = $word.Documents.Open("d:\tugas\MPPL\mie-ayam\docs\Kelompok 5 waroeng mie ayam mastono mahesa hakim atikah jelita.docx")
$text = $doc.Content.Text
$text | Out-File -Encoding utf8 "d:\tugas\MPPL\mie-ayam\docs\extracted_text.txt"
$doc.Close($false)
$word.Quit()
[System.Runtime.Interopservices.Marshal]::ReleaseComObject($word) | Out-Null

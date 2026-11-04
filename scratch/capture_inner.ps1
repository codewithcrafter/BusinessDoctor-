$chrome = "C:\Program Files\Google\Chrome\Application\chrome.exe"
$targets = @(
    @{ Name = "redesign_about_1920.png"; Url = "http://127.0.0.1:8000/about.php"; Width = 1920; Height = 1080 },
    @{ Name = "redesign_services_1920.png"; Url = "http://127.0.0.1:8000/services.php"; Width = 1920; Height = 1080 },
    @{ Name = "redesign_audit_1920.png"; Url = "http://127.0.0.1:8000/audit.php"; Width = 1920; Height = 1080 },
    @{ Name = "redesign_cases_1920.png"; Url = "http://127.0.0.1:8000/case-studies.php"; Width = 1920; Height = 1080 },
    @{ Name = "redesign_contact_1920.png"; Url = "http://127.0.0.1:8000/contact.php"; Width = 1920; Height = 1080 },
    @{ Name = "redesign_service_detail_1920.png"; Url = "http://127.0.0.1:8000/service-detail.php?slug=web-software-development"; Width = 1920; Height = 1080 }
)

foreach ($t in $targets) {
    $outPath = "C:\Users\user\Desktop\businessdoctor\scratch\" + $t.Name
    $size = "--window-size=" + $t.Width + "," + $t.Height
    $argList = @("--headless=new", "--disable-gpu", $size, "--screenshot=$outPath", $t.Url)
    Start-Process -FilePath $chrome -ArgumentList $argList -Wait
    if (Test-Path $outPath) {
        $file = Get-Item $outPath
        Write-Output ("Captured: " + $t.Name + " (" + $file.Length + " bytes)")
    } else {
        Write-Output ("FAILED: " + $t.Name)
    }
}


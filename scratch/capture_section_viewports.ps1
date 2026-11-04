$chrome = "C:\Program Files\Google\Chrome\Application\chrome.exe"
$targets = @(
    @{ Name = "framework_view_1920.png"; Width = 1920; Height = 1080; Url = "http://127.0.0.1:8000/#methodologySection" },
    @{ Name = "framework_view_1440.png"; Width = 1440; Height = 950;  Url = "http://127.0.0.1:8000/#methodologySection" },
    @{ Name = "framework_view_1024.png"; Width = 1024; Height = 900;  Url = "http://127.0.0.1:8000/#methodologySection" },
    @{ Name = "framework_view_768.png";  Width = 768;  Height = 900;  Url = "http://127.0.0.1:8000/#methodologySection" },
    @{ Name = "framework_view_390.png";  Width = 390;  Height = 844;  Url = "http://127.0.0.1:8000/#methodologySection" },
    @{ Name = "framework_view_360.png";  Width = 360;  Height = 800;  Url = "http://127.0.0.1:8000/#methodologySection" }
)

foreach ($t in $targets) {
    $outPath = "C:\Users\user\Desktop\businessdoctor\scratch\" + $t.Name
    $size = "--window-size=" + $t.Width + "," + $t.Height
    $argList = @("--headless=new", "--disable-gpu", $size, "--screenshot=$outPath", $t.Url)
    Start-Process -FilePath $chrome -ArgumentList $argList -Wait
    if (Test-Path $outPath) {
        $len = (Get-Item $outPath).Length
        Write-Output ("VIEWPORT CAPTURED: " + $t.Name + " (" + $len + " bytes)")
    }
}


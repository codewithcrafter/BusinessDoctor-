$chrome = "C:\Program Files\Google\Chrome\Application\chrome.exe"
$viewports = @(
    @{ Name = "framework_1920_full.png"; Width = 1920; Height = 4800 },
    @{ Name = "framework_1440_full.png"; Width = 1440; Height = 5000 },
    @{ Name = "framework_1024_full.png"; Width = 1024; Height = 5400 },
    @{ Name = "framework_768_full.png";  Width = 768;  Height = 6000 },
    @{ Name = "framework_390_full.png";  Width = 390;  Height = 7200 },
    @{ Name = "framework_360_full.png";  Width = 360;  Height = 7500 }
)

foreach ($vp in $viewports) {
    $outPath = "C:\Users\user\Desktop\businessdoctor\scratch\" + $vp.Name
    $size = "--window-size=" + $vp.Width + "," + $vp.Height
    $argList = @("--headless=new", "--disable-gpu", $size, "--screenshot=$outPath", "http://127.0.0.1:8000/")
    Start-Process -FilePath $chrome -ArgumentList $argList -Wait
    if (Test-Path $outPath) {
        $len = (Get-Item $outPath).Length
        Write-Output ("CAPTURED: " + $vp.Name + " (" + $len + " bytes)")
    } else {
        Write-Output ("FAILED: " + $vp.Name)
    }
}


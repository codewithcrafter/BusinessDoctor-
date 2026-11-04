$chrome = "C:\Program Files\Google\Chrome\Application\chrome.exe"
$targets = @(
    @{ Name = "before_approach_1920.png"; Width = 1920; Height = 1080; ScrollY = 2200 },
    @{ Name = "before_approach_1024.png"; Width = 1024; Height = 768; ScrollY = 2500 },
    @{ Name = "before_approach_390.png"; Width = 390; Height = 844; ScrollY = 3200 }
)

foreach ($t in $targets) {
    $outPath = "C:\Users\user\Desktop\businessdoctor\scratch\" + $t.Name
    $size = "--window-size=" + $t.Width + "," + $t.Height
    $argList = @("--headless=new", "--disable-gpu", $size, "--screenshot=$outPath", "http://127.0.0.1:8000/")
    Start-Process -FilePath $chrome -ArgumentList $argList -Wait
}


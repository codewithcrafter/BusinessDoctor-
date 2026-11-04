$routes = @(
    "",
    "about.php",
    "services.php",
    "service-detail.php?slug=web-software-development",
    "audit.php",
    "case-studies.php",
    "case-study-detail.php?slug=fintech-saas-funnel-resuscitation",
    "insights.php",
    "insight-detail.php?slug=the-symptom-trap-why-ad-spend-fails-broken-funnels",
    "contact.php"
)

foreach ($r in $routes) {
    try {
        $resp = Invoke-WebRequest -Uri "http://127.0.0.1:8000/$r" -UseBasicParsing -TimeoutSec 10
        Write-Output ("SUCCESS: " + ($r -replace '^$', 'home') + " => " + $resp.StatusCode)
    } catch {
        Write-Output ("FAILED: " + $r + " => " + $_.Exception.Message)
    }
}


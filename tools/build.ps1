param(
    [string]$Version = "1.0.0",
    [string]$ProjectRoot = (Resolve-Path "$PSScriptRoot\..")
)

$ErrorActionPreference = "Stop"
$slug = "ndsoft-ai-website-doctor"
$dist = Join-Path $ProjectRoot "dist"
$stage = Join-Path $dist $slug
$zip = Join-Path $dist "$slug-$Version.zip"

if (Test-Path $dist) { Remove-Item $dist -Recurse -Force }
New-Item $stage -ItemType Directory -Force | Out-Null

$excludeDirs = @('.git','.github','.vscode','tests','docs','tools','dist','vendor','node_modules')
$excludeFiles = @('.gitignore','.distignore','composer.json','phpunit.xml.dist')

Get-ChildItem $ProjectRoot -Force | Where-Object { $excludeDirs -notcontains $_.Name -and $excludeFiles -notcontains $_.Name } | ForEach-Object {
    Copy-Item $_.FullName $stage -Recurse -Force
}

Compress-Archive -Path $stage -DestinationPath $zip -Force
Write-Host "Built $zip"

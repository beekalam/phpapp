<?php
$links = [
     "http://localhost/xbs",
     "http://localhost/xbs-res",
     "http://crm5.farahoosh.ir/XBS2",
     "http://crm.farahoosh.ir/XBS2",
     "http://crm.farahoosh.ir/AAA",
     "http://crm5.farahoosh.ir/AAA",
     "http://crm5.farahoosh.ir/AAA2/",
     "http://crm.farahoosh.ir/AAA2/",
     "http://localhost/index.php",
     "http://localhost/uplon/uplon-org/themeforest-16607656-uplon-responsive-bootstrap-4-web-app-kit/Admin/PHP/",
     "http://crm5.farahoosh.ir/AAA2/userinfo/120625",
     "http://crm5.farahoosh.ir/AAA2/userinfo/105157",
     "http://localhost/toothpaste/",
     "http://crm5.farahoosh.ir/AAA2/tail",
     "http://crm5.farahoosh.ir/AAA2/xbstail",
     "http://localhost/smartadmin1.5.2"
];

$linksString = "<div style='font-size:14px;line-height:2'>";
foreach($links as $link){
    $linksString .="<a href='" . $link . "'>" . $link . "</a><br/>";
}

$linksString .= "</div>";
// $linksString .= "<a href='" . "file:///home/moh/Documents/beekalam.github.io/index.html"  . "' target='_blank'" . ">index</a>";

echo <<<HTML
<html>
<head>
</head>
<body>
{$linksString}
</body>
</html>

HTML;

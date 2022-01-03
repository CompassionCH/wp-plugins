<?php

echo '
<?xml version="1.0" encoding="utf-8"?>
<svg baseProfile="full" height="315mm" version="1.1" viewBox="0 0 744.094470 372.047240" width="630mm" xmlns="http://www.w3.org/2000/svg" xmlns:ev="http://www.w3.org/2001/xml-events" xmlns:xlink="http://www.w3.org/1999/xlink"><defs/><rect fill="white" height="100%" width="100%" x="0" y="0"/>
    <g>
        <text font-family="Helvetica" font-size="12.0" font-weight="bold" x="17.71654" y="35.43307">'.$qrLang["Receipt"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="17.71654" y="53.14961">'.$qrLang["Amount"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="65.55118">'.$qrData["iban"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="77.95275">'.$qrData["creditor"]["name"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="90.35433">'.$qrData["creditor"]["street"].' '.$qrData["creditor"]["no"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="102.7559">'.$qrData["creditor"]["country"].' '. $qrData["creditor"]["zip"].' '.$qrData["creditor"]["city"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="17.71654" y="118.70078">'.$qrLang["Reference"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="131.10236">'.$qrData["reference"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="17.71654" y="147.04724">'.$qrLang["Payable by"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="159.44881">'.$qrData["debtor"]["name"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="171.85039">'.$qrData["debtor"]["street"].''.$qrData["debtor"]["no"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="184.25196">'.$qrData["debtor"]["country"].' '.$qrData["debtor"]["zip"].' '.$qrData["debtor"]["city"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="17.71654" y="255.1181">'.$qrLang["Currency"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="60.23622" y="255.1181">'.$qrLang["Amount"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="17.71654" y="272.83464">'.$qrData["currency"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="60.23622" y="272.83464">'.$qrData["amount"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" text-anchor="end" x="201.96849" y="304.7244">'.$qrLang["Acceptance point"].'</text><line fill="none" stroke="black" stroke-dasharray="2 2" x1="219.68503" x2="219.68503" y1="0" y2="372.04724"/><path
            d="m 0.764814,4.283977 c 0.337358,0.143009 0.862476,-0.115279 0.775145,-0.523225 -0.145918,-0.497473 -0.970289,-0.497475 -1.116209,-2e-6 -0.0636,0.23988 0.128719,0.447618 0.341064,0.523227 z m 3.875732,-1.917196 c 1.069702,0.434082 2.139405,0.868164 3.209107,1.302246 -0.295734,0.396158 -0.866482,0.368049 -1.293405,0.239509 -0.876475,-0.260334 -1.71099,-0.639564 -2.563602,-0.966653 -0.132426,-0.04295 -0.265139,-0.124595 -0.397393,-0.144327 -0.549814,0.22297 -1.09134,0.477143 -1.667719,0.62213 -0.07324,0.232838 0.150307,0.589809 -0.07687,0.842328 -0.311347,0.532157 -1.113542,0.624698 -1.561273,0.213165 -0.384914,-0.301216 -0.379442,-0.940948 7e-6,-1.245402 0.216628,-0.191603 0.506973,-0.286636 0.794095,-0.258382 0.496639,0.01219 1.013014,-0.04849 1.453829,-0.289388 0.437126,-0.238777 0.07006,-0.726966 -0.300853,-0.765416 -0.420775,-0.157424 -0.870816,-0.155853 -1.312747,-0.158623 -0.527075,-0.0016 -1.039244,-0.509731 -0.904342,-1.051293 0.137956,-0.620793 0.952738,-0.891064 1.47649,-0.573851 0.371484,0.188118 0.594679,0.675747 0.390321,1.062196 0.09829,0.262762 0.586716,0.204086 0.826177,0.378204 0.301582,0.119237 0.600056,0.246109 0.899816,0.36981 0.89919,-0.349142 1.785653,-0.732692 2.698347,-1.045565 0.459138,-0.152333 1.033472,-0.283325 1.442046,0.05643 0.217451,0.135635 -0.06954,0.160294 -0.174725,0.220936 -0.979101,0.397316 -1.958202,0.794633 -2.937303,1.19195 z m -3.44165,-1.917196 c -0.338434,-0.14399 -0.861225,0.116943 -0.775146,0.524517 0.143274,0.477916 0.915235,0.499056 1.10329,0.04328 0.09674,-0.247849 -0.09989,-0.490324 -0.328144,-0.567796 z"
            style="fill:#000000;fill-opacity:1;fill-rule:nonzero;stroke:none"
            transform="scale(1.9) translate(118,40) rotate(90)"/>
        <image x="237.40157000000002" y="50.43307" width="150" height="150" preserveAspectRatio="none" xlink:href="'.$qrData["img"].'"></image>
        <text font-family="Helvetica" font-size="12.0" font-weight="bold" x="237.40157000000002" y="35.43307">'.$qrLang["Payment part"].'</text><path d="" style="fill:#000000;fill-opacity:1;fill-rule:nonzero;stroke:none" transform="translate(237.40157000000002,60) scale(2.6603845901639342)"/>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="237.40157000000002" y="255.1181">'.$qrLang["Currency"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="279.92125000000004" y="255.1181">'.$qrLang["Amount"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="237.40157000000002" y="272.83464">'.$qrData["currency"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="279.92125000000004" y="272.83464">'.$qrData["amount"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="418.11023" y="38.97638">'.$qrLang["Account / Payable to"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="51.37795">'.$qrData["iban"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="63.77953">'.$qrData["creditor"]["name"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="76.1811">'.$qrData["creditor"]["street"].' '.$qrData["creditor"]["no"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="88.58267">'.$qrData["creditor"]["country"].' '. $qrData["creditor"]["zip"].' '.$qrData["creditor"]["city"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="418.11023" y="104.52756">'.$qrLang["Reference"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="116.92913">'.$qrData["reference"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="418.11023" y="132.87401">'.$qrLang["Additional information"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="145.27559">'.$qrData["additional_informations"].'</text>
        <text font-family="Helvetica" font-size="8.0" font-weight="bold" x="418.11023" y="161.22047">'.$qrLang["Payable by"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="173.62204">'.$qrData["debtor"]["name"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="186.02362">'.$qrData["debtor"]["street"].'</text>
        <text font-family="Helvetica" font-size="10.0" x="418.11023" y="198.42519">'.$qrData["debtor"]["country"].' '.$qrData["debtor"]["zip"].' '.$qrData["debtor"]["city"].'</text>
    </g>
</svg>
';

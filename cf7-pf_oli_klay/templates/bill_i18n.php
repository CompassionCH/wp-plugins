<?php



$langs = [
    'Payment part' => [
        'en' => 'Payment part',
        'de' => 'Zahlteil',
        'fr' => 'Section paiement',
        'it' => 'Sezione pagamento'
    ],
    'Account / Payable to' => [
        'fr' => 'Account / Payable to',
        'de' => 'Konto / Zahlbar an',
        'fr' => 'Compte / Payable à',
        'it' => 'Conto / Pagabile a',
    ],
    'Reference' => [
        'en' => 'Reference',
        'de' => 'Referenz',
        'fr' => 'Référence',
        'it' => 'Riferimento'
    ],
    'Additional information' => [
        'en' => 'Additional information',
        'de' => 'Zusätzliche Informationen',
        'fr' => 'Informations supplémentaires',
        'it' => 'Informazioni supplementari',
    ],
    'Currency' => [
        'en' => 'Currency',
        'de' => 'Währung',
        'fr' => 'Monnaie',
        'it' => 'Valuta'
    ],
    'Amount' => [
        'en' => 'Amount',
        'de' => 'Betrag',
        'fr' => 'Montant',
        'it' => 'Importo'
    ],
    'Receipt' => [
        'en' => 'Receipt',
        'de' => 'Empfangsschein',
        'fr' => 'Récépissé',
        'it' => 'Ricevuta'
    ],
    'Acceptance point' => [
        'en' => 'Acceptance point',
        'de' => 'Annahmestelle',
        'fr' => 'Point de dépôt',
        'it' => 'Punto di accettazione'
    ],
    'Separate before paying in' => [
        'en' => 'Separate before paying in',
        'de' => 'Vor der Einzahlung abzutrennen',
        'fr' => 'A détacher avant le versement',
        'it' => 'Da staccare prima del versamento',
    ],
    'Payable by' => [
        'en' => 'Payable by',
        'de' => 'Zahlbar durch',
        'fr' => 'Payable par',
        'it' => 'Pagabile da'
    ],
    'Payable by (name/address)' => [
        'en' => 'Payable by (name/address)',
        'de' => 'Zahlbar durch (Name/Adresse)',
        'fr' => 'Payable par (nom/adresse)',
        'it' => 'Pagabile da (nome/indirizzo)',
    ],
    'Payable by ' => [
        'en' => 'Payable by ',
        'de' => 'Zahlbar bis',
        'fr' => 'Payable jusqu’au',
        'it' => 'Pagabile fino al'
    ],
    'In favour of' => [
        'en' => 'In favour of',
        'de' => 'Zugunsten',
        'fr' => 'En faveur de',
        'it' => 'A favore di'
    ],
];

$qrLang = array();
foreach ($langs as $key => $value) {
    $qrLang[$key] = $value[$qrData['language']];
}

return $qrLang;

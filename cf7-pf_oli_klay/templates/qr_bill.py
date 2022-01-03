#!/usr/bin/env python

import tempfile
from qrbill import QRBill
import sys
import json
import pprint

input = json.load(sys.stdin)

if not input:
    exit()

override_values = {
    'account': 'CH2430808007681434347',
    'creditor': {
        'name': 'Compassion Suisse',
        'line1': '',
        'line2': '',
        'street': 'Rue Galilée',
        'house_num': '3',
        'pcode': '1400',
        'city': 'Yverdon-les-Bains',
        'country': 'Suisse',
    },
    'currency': 'CHF',
    'due_date': None,
    'ref_number': '000000000151089400000600243',
    'alt_procs': (),
    'top_line': False,
    'payment_line': True,
    'font_factor': 1.0,
}

input.update(override_values)
print(json.dumps(input))

my_bill = QRBill(**input)

with tempfile.TemporaryFile(encoding='utf-8', mode='r+') as temp:
    my_bill.as_svg(temp, full_page=False)
    temp.seek(0)
    sys.stdout.write(temp.read())

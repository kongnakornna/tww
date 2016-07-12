#!/bin/sh
cd /www/easycard.club/html/api/mPay
php /www/easycard.club/html/api/mPay/checkmcash.php
cd /www/easycard.club/html/api/IPPS
php /www/easycard.club/html/api/IPPS/updatewallet.php

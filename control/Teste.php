<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teste
 *
 * @author Thyago H Pacher
 */
include("../model/Sms.php");
$sms = new Sms($conn);
echo $sms->enviaSMS("4599630049", "837765", $smsMessage);

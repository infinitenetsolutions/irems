<!DOCTYPE html>
<html>
    <head>
        <title>IREMS | Payslip</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style type="text/css">
        *{
        padding: 0;
        margin: 0;
        }
        html { font-family:Calibri, Arial, Helvetica, sans-serif; font-size:11pt; background-color:white }
        table { border-collapse:collapse; page-break-after:always }
        .gridlines td { border:1px dotted black }
        .gridlines th { border:1px dotted black }
        .b { text-align:center }
        .e { text-align:center }
        .f { text-align:right }
        .inlineStr { text-align:left }
        .n { text-align:right }
        .s { text-align:left }
        td.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style0 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style1 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style1 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style2 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style2 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style3 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style3 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style4 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style5 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style6 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style7 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style7 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style8 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style8 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style9 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style9 { vertical-align:middle; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style10 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style10 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style11 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style11 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style12 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style12 { vertical-align:middle; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style13 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style13 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style14 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style15 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style15 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style16 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style16 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style17 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style18 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style18 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style19 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style19 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style20 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style20 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style21 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style21 { vertical-align:middle; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style22 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style22 { vertical-align:top; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style23 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style23 { vertical-align:top; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style24 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style24 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style25 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style25 { vertical-align:bottom; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style26 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style26 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style27 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style27 { vertical-align:bottom; text-align:left; padding-left:9px; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style28 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style28 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style29 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style29 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style30 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:3px double #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style30 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:3px double #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style31 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style31 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style32 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style32 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:none #000000; border-right:3px double #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style33 { vertical-align:bottom; border-bottom:none #000000; border-top:3px double #000000 !important; border-left:none #000000; border-right:3px double #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style34 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:3px double #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style34 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:3px double #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style35 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:3px double #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style35 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:3px double #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style36 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:3px double #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style36 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:3px double #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style37 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        th.style37 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white }
        td.style38 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style38 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style39 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:none #000000; border-right:3px double #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style39 { vertical-align:bottom; border-bottom:3px double #000000 !important; border-top:none #000000; border-left:none #000000; border-right:3px double #000000 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style40 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
        th.style40 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:10pt; background-color:white }
        td.style41 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style41 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style42 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style42 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style43 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style43 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style44 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style44 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style45 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style45 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style46 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style46 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style47 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style47 { vertical-align:bottom; text-align:right; padding-right:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style48 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style48 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#FFFFFF; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style49 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style49 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style50 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style50 { vertical-align:middle; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style51 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style51 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style52 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style52 { vertical-align:middle; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style53 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style53 { vertical-align:bottom; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style54 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:none #000000; border-right:1px solid #255663 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#255663 }
        th.style54 { vertical-align:bottom; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:none #000000; border-right:1px solid #255663 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#255663 }
        td.style55 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style55 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style56 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style56 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style57 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #255663 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style57 { vertical-align:bottom; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #255663 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style58 { vertical-align:bottom; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style58 { vertical-align:bottom; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style59 { vertical-align:bottom; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style59 { vertical-align:bottom; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style60 { vertical-align:bottom; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #255663 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        th.style60 { vertical-align:bottom; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #255663 !important; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:white }
        td.style61 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:16pt; background-color:#EAF1DD }
        th.style61 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:16pt; background-color:#EAF1DD }
        td.style62 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:16pt; background-color:#EAF1DD }
        th.style62 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:16pt; background-color:#EAF1DD }
        td.style63 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:16pt; background-color:#EAF1DD }
        th.style63 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:16pt; background-color:#EAF1DD }
        td.style64 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style64 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style65 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style65 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style66 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style66 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style67 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style67 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style68 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style68 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style69 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style69 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-style:italic; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style70 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        th.style70 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        td.style71 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        th.style71 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        td.style72 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        th.style72 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        td.style73 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        th.style73 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        td.style74 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        th.style74 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        td.style75 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        th.style75 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:16pt; background-color:#f4b034 }
        td.style76 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:24pt; background-color:white }
        th.style76 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:24pt; background-color:white }
        td.style77 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style77 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style78 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        th.style78 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:12pt; background-color:white }
        td.style79 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style79 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style80 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style80 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style81 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style81 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style82 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style82 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style83 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style83 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style84 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style84 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style85 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style85 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style86 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style86 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style87 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        th.style87 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#000000; font-family:'Arial'; font-size:22pt; background-color:#000000 }
        td.style88 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        th.style88 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        td.style89 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        th.style89 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        td.style90 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        th.style90 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:1px solid #000000 !important; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        td.style91 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        th.style91 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:1px solid #000000 !important; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        td.style92 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        th.style92 { vertical-align:middle; text-align:center; border-bottom:1px solid #000000 !important; border-top:1px solid #000000 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFFFF; font-family:'Arial'; font-size:12pt; background-color:#57a247 }
        td.style93 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#DAEEF3 }
        th.style93 { vertical-align:top; text-align:left; padding-left:0px; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:11pt; background-color:#DAEEF3 }
        td.style94 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#FFFF00; font-family:'Calibri'; font-size:16pt; background-color:#255663 }
        th.style94 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#FFFF00; font-family:'Calibri'; font-size:16pt; background-color:#255663 }
        td.style95 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFF00; font-family:'Calibri'; font-size:16pt; background-color:#255663 }
        th.style95 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#FFFF00; font-family:'Calibri'; font-size:16pt; background-color:#255663 }
        td.style96 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        th.style96 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        td.style97 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        th.style97 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:1px solid #255663 !important; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        td.style98 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        th.style98 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        td.style99 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        th.style99 { vertical-align:middle; text-align:center; border-bottom:none #000000; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        td.style100 { vertical-align:middle; text-align:center; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        th.style100 { vertical-align:middle; text-align:center; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:1px solid #255663 !important; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        td.style101 { vertical-align:middle; text-align:center; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        th.style101 { vertical-align:middle; text-align:center; border-bottom:1px solid #255663 !important; border-top:none #000000; border-left:none #000000; border-right:none #000000; font-weight:bold; color:#255663; font-family:'Calibri'; font-size:26pt; background-color:#DAEEF3 }
        td.style110 { vertical-align:middle; text-align:left; padding-left:9px; border-bottom:1px solid #000000 !important; border-top:none #000000; border-left:1px solid #000000 !important; border-right:none #000000; color:#000000; font-family:'Calibri'; font-size:12pt; background-color:white}  table.sheet0 col.col0 { width:16.94444425pt }
        table.sheet0 col.col1 { width:13.5555554pt }
        table.sheet0 col.col2 { width:146.39999832pt }
        table.sheet0 col.col3 { width:13.5555554pt }
        table.sheet0 col.col4 { width:146.39999832pt }
        table.sheet0 col.col5 { width:146.39999832pt }
        table.sheet0 col.col6 { width:13.5555554pt }
        table.sheet0 col.col7 { width:146.39999832pt }
        table.sheet0 col.col8 { width:13.5555554pt }
        table.sheet0 col.col9 { width:13.5555554pt }
        table.sheet0 col.col10 { width:42.02222174pt }
        table.sheet0 col.col11 { width:42.02222174pt; visibility:collapse; *display:none }
        table.sheet0 tr { height:15pt }
        table.sheet0 tr.row0 { height:16.25pt }
        table.sheet0 tr.row1 { height:16.25pt }
        table.sheet0 tr.row2 { height:25pt }
        table.sheet0 tr.row3 { height:25pt }
        table.sheet0 tr.row4 { height:25pt }
        table.sheet0 tr.row5 { height:10pt }
        table.sheet0 tr.row6 { height:25pt }
        table.sheet0 tr.row7 { height:25pt }
        table.sheet0 tr.row8 { height:25pt }
        table.sheet0 tr.row9 { height:10pt }
        table.sheet0 tr.row10 { height:25pt }
        table.sheet0 tr.row11 { height:10pt }
        table.sheet0 tr.row12 { height:25pt }
        table.sheet0 tr.row13 { height:25pt }
        table.sheet0 tr.row14 { height:25pt }
        table.sheet0 tr.row15 { height:25pt }
        table.sheet0 tr.row16 { height:25pt }
        table.sheet0 tr.row17 { height:25pt }
        table.sheet0 tr.row18 { height:25pt }
        table.sheet0 tr.row19 { height:25pt }
        table.sheet0 tr.row20 { height:10pt }
        table.sheet0 tr.row21 { height:25pt }
        table.sheet0 tr.row22 { height:25pt }
        table.sheet0 tr.row23 { height:25pt }
        table.sheet0 tr.row24 { height:25pt }
        table.sheet0 tr.row25 { height:25pt }
        table.sheet0 tr.row26 { height:16pt }
        table.sheet0 tr.row27 { height:16pt }
        .float{
        position:fixed;
        width:60px;
        height:60px;
        bottom:40px;
        right:40px;
        background-color:#bec2bf;
        color:#FFF;
        border-radius:50px;
        text-align:center;
        box-shadow: 2px 2px 3px #999;
        }
        .my-float{
        margin-top:15px;
        }
        </style>
        <style type="text/css" media="print">
        @media print
        {
        @page {
        margin-top: 0;
        margin-bottom: 0;
        }
        body  {
        padding: 0% 0% 0% 0%;
        }
        .float{
        display: none;
        }
        }
        </style>
    </head>
    <body>
        <?php
         $sum_pf_cmp=$sum_esic_cmp=$sum_gross_salary=0;
         $month_num = $_GET['month'];
         $twd = $_GET['twd']; //get total working days
         $tpd = $_GET['tpd']; //get total Present days
         $loan = $_GET['loan']; //get total loan
         $esi = $_GET['esi']; //get total esi
         $epf = $_GET['epf']; //get total epf
         $disincentive = $_GET['disincentive']; //get total disincentive
         $netSalary = $_GET['netSalary']; //get net salary
         $month_name = date("F", mktime(0, 0, 0, $month_num, 10));
        foreach($employee as $row){
        $manage_employee_info= json_decode($row["manage_employee_info"]);
                $eid=$_GET['eid'];
                $date=$_GET['year']."-".$_GET['month']."-01";
                $startDate=date("Y-m-01", strtotime($date));
                $endDate=date("Y-m-t", strtotime($date)); 
				
               //$desig_id = $manage_employee_info->designation;
               //echo $desig_id;
                //$did = $this->Designation_model->get_data_array();
                //$dd11 = $this->Designation_model->get_designation_by_id($desig_id);
                //echo "<pre>";
                //print_r($dd11);
                $desig11= json_decode($desig["manage_designation_info"]);
                $ds = $desig11->designationName; 
                                
               // $department = $this->dm->get_department_by_id($row['department']);
             // $designation = $this->designation->get_designation_by_id($row['designation']);
                /*$calender_data=$this->Payroll_model->get_calender_data($_GET['month'],$_GET['year']);
                $cut_from = $row['cut_from']; 
                $pf_emp = (intval($row[$cut_from])*intval($row['pf_emp'])*(0.01));
                $esic_emp = (intval($row[$cut_from])*intval($row['esic_emp'])*(0.01));
                $net_salary=intval($row['total_salary'])-($pf_emp+$esic_emp);
                $pf_esic_cut_from=($row['cut_from']=='basic_salary')?'Basic Salary':'Gross Salary';
                $workdays=$this->Payroll_model->get_working_days($startDate,$endDate); */ //count working days
        ?>
        <center><table border="0" cellpadding="0" cellspacing="0" id="sheet0" class="sheet0">
            <colgroup><col class="col0">
            <col class="col1">
            <col class="col2">
            <col class="col3">
            <col class="col4">
            <col class="col5">
            <col class="col6">
            <col class="col7">
            <col class="col8">
            <col class="col9">
            <col class="col10">
            <col class="col11">
            </colgroup><tbody>
                <tr class="row0">
                    <td class="column0">&nbsp;</td>
                    <td class="column1">&nbsp;</td>
                    <td class="column2">&nbsp;</td>
                    <td class="column3">&nbsp;</td>
                    <td class="column4">&nbsp;</td>
                    <td class="column5">&nbsp;</td>
                    <td class="column6">&nbsp;</td>
                    <td class="column7">&nbsp;</td>
                    <td class="column8">&nbsp;</td>
                    <td class="column9">&nbsp;</td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                </tr>
                <tr class="row1">
                    <td class="column0">&nbsp;</td>
                    <td class="column1 style30 null"></td>
                    <td class="column2 style31 null"></td>
                    <td class="column3 style31 null"></td>
                    <td class="column4 style31 null"></td>
                    <td class="column5 style31 null"></td>
                    <td class="column6 style31 null"></td>
                    <td class="column7 style31 null"></td>
                    <td class="column8 style32 null"></td>
                    <td class="column9 style33 null"></td>
                    <td class="column10">&nbsp;</td>
                    <td class="column11">&nbsp;</td>
                </tr>
                <tr class="row2">
                    <td class="column0">&nbsp;</td>
                    <td class="column1 style34"></td>
                    <td class="column4 style76 s style76" colspan="7" rowspan="2">
                        <img src="https://srinathhomes.in/images/logo.png" height="auto" width="120px" style=" float:right; margin-left: 10px">
                        <h5 style=" float:left;margin-left: 24%">SRINATH HOMES<br><p style="font-size: 14px;">Address - 112, 1st Floor, Ashiana Trade Centre, Adityapur, Jamshedpur, Jharkhand- 831013<br></p></h5>
                        <p style="font-size: 14px;  float:left;margin-left: 47%">Phone no : 7004891857 <br> </p></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row3">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row4">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        
                        <td class="column4 style77 s style78" colspan="7">Salary Slip for <?php echo $month_name.'\''.$_GET['year'];?></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row5">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style1 null"></td>
                        <td class="column3 style2 null"></td>
                        <td class="column4 style3 null"></td>
                        <td class="column5 style1 null"></td>
                        <td class="column6 style2 null"></td>
                        <td class="column7 style2 null"></td>
                        <td class="column8 style15 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row6">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Name</td>
                        <td class="column3 style14 s">:</td>
                        <td class="column4 style5 s"><?= $manage_employee_info->firstName.' '. $manage_employee_info->lastName; ?></td>
                        <td class="column5 style26 s">Date</td>
                        <td class="column6 style14 s">:</td>
                        <td class="column7 style4 s"><?php echo date("d-m-Y")?></td>
                        <td class="column8 style16 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row7">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Employee ID</td>
                        <td class="column3 style14 s">:</td>
                        <td class="column4 style5 s"><?= $manage_employee_info->employeeId; ?></td>
                        <td class="column5 style26 s">Designation</td>
                        <td class="column6 style14 s">:</td>
                        <td class="column7 style4 s"><?php echo $ds; ?></td>
                        <td class="column8 style16 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row8">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style27 null"></td>
                        <td class="column3 style25 null"></td>
                        <td class="column4 style8 null"></td>
                        <td class="column5 style26 s"></td>
                        <td class="column6 style14 s"></td>
                        <td class="column7 style4 s"></td>
                        <td class="column8 style16 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row10">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style90 s style91" colspan="3">Earnings</td>
                        <td class="column5 style90 s style91" colspan="2">Amounts</td>
                        <td class="column7 style88 s style89" colspan="2">Deductions</td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row11">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 null"></td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style5 null"></td>
                        <td class="column5 style9 null"></td>
                        <td class="column6 style4 null"></td>
                        <td class="column7 style20 null"></td>
                        <td class="column8 style15 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row12">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Basic Salary</td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style5 null"></td>
                        <td class="column5 style9 n">₹<?= $manage_employee_info->basicSalary; ?></td>
                        <td class="column6 style4 null"></td>
                        <td class="column7 style21 null">&nbsp; EPF Contribution</td>
                        <td class="column8 style16 null">₹<?= $epf; ?></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row13">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">House Rent Allowance</td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style5 null"></td>
                        <td class="column5 style9 n">₹ <?= $manage_employee_info->hra; ?></td>
                        <td class="column6 style4 null"></td>
                        <td class="column7 style21 null">&nbsp; ESI Contribution</td>
                      <td class="column8 style16 null"> ₹<?= $esi; ?></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row14">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Travell Allowance</td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style5 null"></td>
                        <td class="column5 style9 n">₹ <?= $manage_employee_info->ta; ?></td>
                        <td class="column6 style4 null"></td>
                        <td class="column7 style21 null">&nbsp; Loan EMI</td>
                      <td class="column8 style16 null">₹<?= $loan; ?></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row15">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Service Allowance</td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style5 null"></td>
                        <td class="column5 style9 n">₹ <?= $manage_employee_info->sa; ?></td>
                        <td class="column6 style4 null"></td>
                        <td class="column7 style21 null">&nbsp; Disincentive</td>
                        <td class="column8 style16 null">₹<?= $disincentive ?></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                  
                   
                   
                    
                    <!---->
                    <tr class="row17">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Total Working Days</td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style10 null"></td>
                        <td class="column5 style9 null"><?= $twd; ?></td>
                        <td class="column6 style19 null"></td>
                        <td class="column7 style22 n"></td>
                        <td class="column8 style16 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row18">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 null">Total Present Days</td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style10 null"></td>
                        <td class="column5 style9 null"><?= $tpd; ?></td>
                        <td class="column6 style19 null"></td>
                        <td class="column7 style22 null"></td>
                        <td class="column8 style16 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row19">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 null"></td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style5 null"></td>
                        <td class="column5 style9 null"></td>
                        <td class="column6 style19 null"></td>
                        <td class="column7 style22 null"></td>
                        <td class="column8 style16 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row20">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 null"></td>
                        <td class="column3 style4 null"></td>
                        <td class="column4 style4 null"></td>
                        <td class="column5 style9 null"></td>
                        <td class="column6 style19 null"></td>
                        <td class="column7 style23 null"></td>
                        <td class="column8 style18 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row21">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style28 s">Total</td>
                        <td class="column3 style11 null"></td>
                        <td class="column4 style11 null"></td>
                        <td class="column5 style49 f">₹ <?= $manage_employee_info->totalSalary ?> </td>
                        <td class="column6 style50 null"></td>
                        <td class="column7 style49 f"></td>
                        <td class="column8 style51 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row22">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style28 s">Bank Name</td>
                        <td class="column3 style11 s">:<?= $manage_employee_info->bankName ?> </td>
                        <td class="column4 style52 n"></td>
                        <td class="column5 style90 s style91" colspan="4">NET PAY</td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row23">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Branch</td>
                        <td class="column3 style4 s">:<?= $manage_employee_info->branch ?></td>
                        <td class="column4 style4 s"></td>
                        <td class="column5 style61 f style63" colspan="4">₹ <?= $netSalary ?> </td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row24">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style26 s">Bank A/c</td>
                        <td class="column3 style4 s">:<?= $manage_employee_info->acc_no ?></td>
                        <td class="column4 style4 s"></td>
                        <td class="column5 style64 f style69" colspan="4" rowspan="2"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row25">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style29 s"></td>
                        <td class="column3 style12 s"></td>
                        <td class="column4 style24 n"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    
                    <tr class="row2">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style34 null"></td>
                        <td class="column2 style110 null" colspan="2"><center><small><b>RECEIVER NAME <br><br><br> Signature</b></small> </center></td>
                        <td class="column4 style110 null"><br><br><br><center><small><b>COMPANY SEAL HERE</b></small></center></td>
                        <td class="column4 style110 s" colspan="3"><small><b>For,<br>
                            Company Name - Srinath Homes<br>
                            <br>
                             </b></small></td>
                        <td class="column8 style51 null"></td>
                        <td class="column9 style35 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <tr class="row26">
                        <td class="column0">&nbsp;</td>
                        <td class="column1 style36 null"></td>
                        <td class="column2 style37 null"></td>
                        <td class="column3 style37 null"></td>
                        <td class="column4 style37 null"></td>
                        <td class="column5 style37 null"></td>
                        <td class="column6 style37 null"></td>
                        <td class="column7 style37 null"></td>
                        <td class="column8 style38 null"></td>
                        <td class="column9 style39 null"></td>
                        <td class="column10">&nbsp;</td>
                        <td class="column11">&nbsp;</td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table></center>
            <a href="#" class="float" onclick="window.print();">
                <i class="fa fa-print my-float" style="font-size:32px;color: #000;"></i>
            </a>
        </body>
    </html>
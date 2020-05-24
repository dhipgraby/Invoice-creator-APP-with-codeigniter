<style>
    /* GENERAL SETTINGS */
    @page {
        margin:0.5cm 0cm 0cm 0cm;
    }

    p {
        line-height: 1.2;
        font-size: 12px;        
        margin: 0px;
        font-family: Trebuchet MS, sans-serif;
    }



    .header {
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 2cm;
        /** Extra personal styles **/
        background-color: #03a9f4;
        color: white;

    }

    .grey-bg {
        background-color: #AFABAB;
    }

    .grey-c {
        color: #afabab;
    }


    body {

        margin: 0px;
        margin-top: 10px;
        margin-bottom: -10px;
        font-family: Trebuchet MS, sans-serif;
        color: #5b5b5b;
    }

    .logo {
        width: 150px;
    }

    hr {
        page-break-after: avoid;
        border: 0;
        margin: 0;
        padding: 0;
    }

    .yellow-hr {
        width: 100%;
        border-bottom: 2px solid #dfee06;

    }

    /* Table */

    .t-border {

        border: solid 1px #5b5b5b;
        border-collapse: collapse;
    }

    .side-border {

        border-right: solid 1px #5b5b5b;

    }

    /* FONT */

    .tsp-1 {
        letter-spacing: 1px;
    }

    .fw-1 {
        font-weight: 300;
    }

    .fw-2 {
        font-weight: 500;
    }

    .fw-3 {
        font-weight: 600;
    }

    .fw-4 {
        font-weight: 700;
    }

    /* SIZING */

    .m-0 {
        margin: 0px;
    }

    .m-1 {
        margin: 5px;
    }

    .mt-0 {
        margin-top: 0px;
    }

    .mt-05 {
        margin-top: 5px;
    }

    .mt-1 {
        margin-top: 10px;
    }

    .mt-2 {
        margin-top: 30px;
    }

    .mt-3 {
        margin-top: 50px;
    }

    .mt-4 {
        margin-top: 80px;
    }

    .mb-0 {
        margin-bottom: 5px;
    }

    .mb-1 {
        margin-bottom: 10px;
    }

    .mb-2 {
        margin-bottom: 30px;
    }

    .mb-3 {
        margin-bottom: 50px;
    }

    .mb-4 {
        margin-bottom: 80px;
    }

    .ml-1 {
        margin-left: 10px;
    }

    .ml-2 {
        margin-left: 20px;
    }

    .ml-3 {
        margin-left: 30px;
    }

    .ml-4 {
        margin-left: 45px;
    }

    .mr-1 {
        margin-right: 10px;
    }

    .mr-2 {
        margin-right: 20px;
    }

    .mr-3 {
        margin-right: 30px;
    }

    .mr-4 {
        margin-right: 45px;
    }

    .p-1 {
        padding: 1px;
    }

    .p-2 {
        padding: 10px;
    }

    .p-3 {
        padding: 15px;
    }

    .p-4 {
        padding: 20px;
    }

    .p-5 {
        padding: 25px;
    }

    .pt-0 {
        padding-top: 0px;
    }

    .pt-05 {
        padding-top: 5px;
    }

    .pt-1 {
        padding-top: 10px;
    }

    .pt-2 {
        padding-top: 20px;
    }

    .pt-3 {
        padding-top: 30px;
    }

    .pt-4 {
        padding-top: 40px;
    }

    .pt-5 {
        padding-bottom: 50px;
    }

    .pb-1 {
        padding-bottom: 10px;
    }

    .pb-2 {
        padding-bottom: 20px;
    }

    .pb-3 {
        padding-bottom: 30px;
    }

    .pb-4 {
        padding-bottom: 40px;
    }

    .pb-5 {
        padding-bottom: 50px;
    }

    .mw-10 {
        width: 10%;
    }

    .mw-20 {
        width: 20%;
    }

    .mw-30 {
        width: 30%;
    }

    .mw-40 {
        width: 40%;
    }

    .mw-50 {

        width: 50%;

    }

    .mw-60 {

        width: 60%;

    }

    .mw-70 {

        width: 70%;

    }

    .mw-80 {

        width: 80%;

    }

    .mw-100 {

        width: 100%;

    }

    .mw-120 {

        width: 120%;

    }

    .mw-150 {

        width: 150%;

    }

    /* ALIGNMENT */

    .pl-1 {
        padding-left: 10px;
    }

    .pl-2 {
        padding-left: 15px;
    }

    .pl-25 {
        padding-left: 20px;
    }

    .pl-3 {
        padding-left: 40px;
    }

    .pl-35 {
        padding-left: 35px;
    }

    .pl-4 {
        padding-left: 50px;
    }

    .pl-5 {
        padding-left: 65px;
    }

    .pr-1 {
        padding-right: 10px;
    }

    .pr-2 {
        padding-right: 15px;
    }

    .pr-25 {
        padding-right: 20px;
    }

    .pr-3 {
        padding-right: 40px;
    }

    .pr-35 {
        padding-right: 35px;
    }

    .pr-4 {
        padding-right: 50px;
    }

    .ta-l {

        text-align: left;
    }

    .ta-c {

        text-align: center;

    }

    .ta-r {

        text-align: right;

    }

    .table-center tr {

        text-align: center;
    }

    /* COLORS */

    .black {
        color: #000000;
    }

    .c-white {

        color: #ffffff;
    }

    .main_div {

        background: url('images/f_building2.png') no-repeat;
        background-position: center;
        background-size: cover;
        width: 100%;
        height: 200px;
    }

    .footer_div {                
        display: block;
        position: absolute; 
        bottom:15;
           
        background: url('images/footer_building.png') no-repeat;
        background-position: center;
        background-size: cover;
        width: 100%;
        height: 210px;
    }
</style>
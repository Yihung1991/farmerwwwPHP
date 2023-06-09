<style>
    /* fornavbar */
    .container-fluid {
        width: 90vw;
    }

    nav.navbar .navbar-nav .nav-link.active {
        background-color: blue;
        color: white;
        font-weight: 800;
        border-radius: 10px;
    }

    /* forsidebar */
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }

    .bi {
        vertical-align: -.125em;
        fill: currentColor;
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    /* .container {
        width: 100%;
    } */

    .focused {
        background-color: #198754 !important;
        color: white;

    }

    /* piechart */



    @keyframes bake-pie {
        from {
            transform: rotate(0deg) translate3d(0, 0, 0);
        }
    }

    .pie-chart {
        font-family: "Open Sans", Arial;
    }

    .pie-chart--wrapper {
        width: 400px;
        margin: 30px auto;
        text-align: center;
    }

    .pie-chart__pie,
    .pie-chart__legend {
        display: inline-block;
        vertical-align: top;
    }

    .pie-chart__pie {
        position: relative;
        height: 200px;
        width: 200px;
        margin: 10px auto 35px;
    }

    .pie-chart__pie::before {
        content: "";
        display: block;
        position: absolute;
        z-index: 1;
        width: 100px;
        height: 100px;
        background: #EEE;
        border-radius: 50%;
        top: 50px;
        left: 50px;
    }

    .pie-chart__pie::after {
        content: "";
        display: block;
        width: 120px;
        height: 2px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        box-shadow: 0 0 3px 4px rgba(0, 0, 0, 0.1);
        margin: 220px auto;
    }

    .slice {
        position: absolute;
        width: 200px;
        height: 200px;
        clip: rect(0px, 200px, 200px, 100px);
        animation: bake-pie 1s;
    }

    .slice span {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        background-color: black;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        clip: rect(0px, 200px, 200px, 100px);
    }

    .pie-chart__legend {
        display: block;
        list-style-type: none;
        padding: 0;
        margin: 0 auto;
        background: #FFF;
        padding: 0.75em 0.75em 0.05em;
        font-size: 13px;
        box-shadow: 1px 1px 0 #DDD, 2px 2px 0 #BBB;
        text-align: left;
        width: 65%;
    }

    .pie-chart__legend li {
        height: 1.25em;
        margin-bottom: 0.7em;
        padding-left: 0.5em;
        border-left: 1.25em solid black;
    }

    .pie-chart__legend em {
        font-style: normal;
    }

    .pie-chart__legend span {
        float: right;
    }

    .pie-charts {
        display: flex;
        flex-direction: row;
    }

    @media (max-width: 500px) {
        .pie-charts {
            flex-direction: column;
        }
    }

    .a {
        text-decoration: none;
        color: #198754;

    }

    .a:hover {
        text-decoration: none;
        color: #EEE;
    }

    .a-i {
        text-decoration: none;
        color: #198754;

    }

    .a-i:hover {
        text-decoration: none;
        color: #67B0C1;
    }

    .btn.btn-outline-success:focus {
        background-color: #198754;
    }
</style>



<body>
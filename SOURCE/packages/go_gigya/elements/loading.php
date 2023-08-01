<style>

    #loader-window {
        border: 1px solid red;
        height: 100%;
    }

    #loader {
        position: absolute;
        left: 50%;
        top: 50%;
        z-index: 1;
        margin: -75px 0 0 -75px;
        border: 10px solid #f3f3f3;
        border-radius: 50%;
        border-top: 10px solid #3498db;
        width: 50px;
        height: 50px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<div id="loader-window">
    <div id="loader"></div>
</div>

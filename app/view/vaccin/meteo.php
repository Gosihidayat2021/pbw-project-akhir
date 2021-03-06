<?php
require($root . '/app/view/fragment/fragmentHeader.html');
?>

<body>
<div class="container">
    <?php
    include $root . '/app/view/fragment/fragmentMenu.html';
    include $root . '/app/view/fragment/fragmentJumbotron.html';
    ?>

    <h2>How should I dress to go for the vaccine?</h2>
    <div>
        <h3 class="h3">He is currently doing <strong><span id="degree"></span> degrees</strong> outside at <span
                    id="ville"></span> !</h3>
        <span class="h5">We advise you to get vaccinated by:</span>
        <img id="habit" src="" height="200" width="200" alt="image habit">
    </div>
</div>
<script>
    const API_KEY = "6047186d0e4573fe07c6d703e89fecba";

    let ville = "Troyes";
    const getData = async () => {
        let meteo = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${ville},fr&appid=${API_KEY}&units=metric`).then(x => x.json())
        return await meteo.main.temp
    }

    const main = async () => {
        let temp = await getData()
        temp = Number(temp)
        let img = ""
        if (temp > 30) {
            img = "imgs/maillot.jpg"
        } else if (temp > 23) {
            img = "imgs/tshirt.jpg"
        } else if (temp > 14) {
            img = "imgs/pull.jpg"
        } else {
            img = "imgs/manteau"
        }
        document.getElementById('habit').src = "../../public/" + img;
        document.getElementById('degree').textContent = Math.round(temp);
        document.getElementById('ville').textContent = ville
    }
    main()

</script>

<?php
include $root . '/app/view/fragment/fragmentFooter.html'; ?>
<p><em>Data retrieved from OpenWheatherApi</em></p>
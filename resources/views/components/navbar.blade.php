<nav id="myP" class="awowo-hop">
    <div id="aaa" class="m-3">
        <a href="#">
            <img src="{{url('/img/logo-item.png')}}" alt="" style="width: 60px">
        </a>
    </div>
    <div class="ms-5">
        <ul class="d-flex flex-row mb-0">
            <li class="mx-4" style="list-style: none"><a href="/#jumbotron" style="text-decoration: none; color: #483434; font-weight: bold; font-size: 20px">Home</a></li>
            <li class="mx-4" style="list-style: none"><a href="/#service" style="text-decoration: none; color: #483434; font-weight: bold; font-size: 20px">Layanan Kami</a></li>
            <li class="mx-4" style="list-style: none"><a href="/#orderpage" style="text-decoration: none; color: #483434; font-weight: bold; font-size: 20px">Menu</a></li>
        </ul>
    </div>
</nav>

<script>
    window.onscroll = function() {myFunction()};

    function myFunction() {
    if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
        document.getElementById("myP").className = "awowo";
    } else {
        document.getElementById("myP").className = "awowo-hop";
    }
    }
</script>
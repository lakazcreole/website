<section class="menu my-5" id="la-carte">
    <div class="container">
        <h2 class="text-center mb-4">La carte</h2>
        <div class="card-deck">
            <div class="card">
                <img class="card-img-top" style="height:300px" src="{{ asset('/images/bouchons.jpg') }}" alt="Bonbons porc Réunion"/>
                <div class="card-body">
                    <h3 class="card-title">Entrées</h3>
                    <ul>
                        <li>Samoussas</li>
                        <li>Bouchons</li>
                        <li>Bonbons piment</li>
                    </ul>
                    <p class="card-text">Aussi disponibles en plateau apéritif.</p>
                </div>
            </div>
            <div class="card">
                <img class="card-img-top" style="height:300px" src="{{ asset('/images/cari-poulet.jpg') }}" alt="Cari poulet Paris">
                <div class="card-body">
                    <h3 class="card-title">Plats</h3>
                    <ul>
                        <li>Rougail saucisse</li>
                        <li>Cari poulet</li>
                        <li>Shop suey de légumes</li>
                    </ul>
                    <p class="card-text">... et bien d'autres !</p>
                </div>
            </div>
            <div class="card">
                <div class="tag text-center">Bientôt disponible</div>
                <img class="card-img-top" style="height:300px" src="./images/gateau-patate.jpg" alt="Gâteau patate maison">
                <div class="card-body">
                    <h3 class="card-title">Desserts</h3>
                    <ul>
                        <li>Gâteau patate</li>
                        <li>Bonbons miel</li>
                        <li>Fruits exotiques</li>
                    </ul>
                    <p class="card-text">Il reste toujours une place pour le dessert.</p>
                </div>
            </div>
        </div>
        <div class="text-center my-5">
            <button class="btn btn-lg btn-primary btn-big mx-auto" @click="openOrder">Commander</button>
        </div>
    </div>
</section>

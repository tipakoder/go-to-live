<div class="form-action">
    <h1 class="form-title">Специальности нашей клиники</h1>
    <div class="cards-el">
        <?foreach($types as $type):?>
            <div class="card">
                <div class="card-text">
                    <h2 class="card-text-name"><?=$type['name']?></h2>
                    <p class="card-text-description"><?=$type['description']?></p>
                </div>
            </div>
        <?endforeach;?>
    </div>
</div>
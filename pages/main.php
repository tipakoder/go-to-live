<div class="form-action">
    <h1 class="form-title">Специальности нашей клиники</h1>
    <div class="cards-el">
        <?
        $elc = 0;
        $pc = 1;
        foreach($types as $type):
            $elc++;
        ?>
            
            <div class="card card-page-<?=$pc?>" <?if($pc > 1){echo 'style="display: none;"';}?>>
                <div class="card-text">
                    <h2 class="card-text-name"><?=$type['name']?></h2>
                    <p class="card-text-description"><?=$type['description']?></p>
                </div>
            </div>
        <?
            if($elc == 4)
            {
                $elc = 0;
                $pc++;
            }
        endforeach;?>
    </div>
    <div class="pages-tabs">
        <? for($i = 1; $i < $pc; $i++){ ?>
            <div class="page-tab" pid="<?=$i?>"><?=$i?></div>
        <? } ?>
    </div>
</div>

<script src="/res/js/index.js"></script>
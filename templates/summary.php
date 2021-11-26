<main class="container-fluid bg-image">
            <div class="row justify-content-center">
                <div class="col-10 card p-5 m-5 rounded-3">
                    <div class="card-body">
                        <h2 class="card-title">Votre demande a été envoyé.</h2>
                        <p class="card-text mb-5">Nous traiteront votre demande dans les plus brèves délais.</p>
                        <div class="row justify-content-md-center border-top">
                            <h3 class="my-3">Récapitulatif</h3>
                            <div class="col<?php
                            if ('one-way' == $valuesForm['trip-type']) echo "-6" ;
                            ?>">
                                <div class="card mt-5 rounded-3 bg-primary text-white">
                                    <h4 class="card-header">Vol aller</h4>
                                    <div class="card-body">
                                        <p>Depuis : <?= $valuesForm['city-start'];?></p>
                                        <p>Vers : <?= $valuesForm['city-to'];?></p>
                                        <p>Le 
                                            <?php
                                            $valuesFormDate = strftime('%a. %d %b %G',strtotime($valuesForm['departure-date']));
                                            $valuesFormTime = strftime('%H:%M ',strtotime($valuesForm['departure-date']));

                                            if (!empty($valuesForm['departure-date']) && strtotime($valuesForm['departure-date'])) {
                                                echo $valuesFormDate . ' ' . $valuesFormTime;
                                            };?>
                                        </p>
                                        <p>En classe <?= Dataform::translateTripClass($valuesForm['trip-class']);?></p>
                                        <p>Pour <?= $valuesForm['number-of-passenger'];?> personne(s)</p>
                                    </div>
                                </div>
                            </div>
                            <?php if('round-trip' == $valuesForm['trip-type']): ;?>
                                <div class="col">
                                    <div class="card mt-5 rounded-3 bg-primary text-white">
                                        <h4 class="card-header">Vol retour</h4>
                                        <div class="card-body">
                                            <p>Depuis : <?= $valuesForm['city-to'];?></p>
                                            <p>Vers : <?= $valuesForm['city-start'];?></p>
                                            <p>Le 
                                                <?php
                                                $valuesFormDate = strftime('%a. %d %b %G',strtotime($valuesForm['return-date']));
                                                $valuesFormTime = strftime('%H:%M ',strtotime($valuesForm['return-date']));

                                                if (!empty($valuesForm['return-date']) && strtotime($valuesForm['return-date'])) {
                                                    echo $valuesFormDate . ' ' . $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>En classe <?= Dataform::translateTripClass($valuesForm['trip-class']);?></p>
                                            <p>Pour <?= $valuesForm['number-of-passenger'];?> personne(s)</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ;?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
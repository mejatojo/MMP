@extends('app.app')
@section('content')<!-- End Hero -->
<section id="hero">
    <div class="hero-container" data-aos="fade-up">
      <h1>Maintenance Mobile Pneumatique</h1>
      <h2>Assistance à la gestion de flotte automobile</h2>   
      <img src="{{asset('assets/img/MMPl.png')}}" width="80px" height="90px">
       </div>
  </section>
  <main id="main">
 
    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-xl-6 col-lg-6 video-box d-flex justify-content-center align-items-stretch" data-aos="zoom-in">
            <!-- <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a> -->
          </div>

          <div class="col-xl-6 col-lg-6 d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5" style="text-align: justify;">
            <div class="box-heading" data-aos="fade-up" style="margin-left: 2cm;">
              <!-- <h4>MMP</h4> -->
              <h3>La solution pour votre flotte automobile !</h3>
            </div>

            <div class="icon-box" data-aos="fade-up">
              <div class="icon"><i class="bx bx-wrench"></i></div>
              <h4 class="title">Maintenance prédictive</h4>
              <p class="description">La maintenance Mobile prédictive pour tous les pneus de votre flotte automobile. 
              Avec un contrat de maintenance "<font style="font-style: oblique;">objectif 1.6 mm</font> " Un passage régulier et programmé pour une remise en pression de votre parc auto. </p>
            </div>

            <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
              <div class="icon"><i class="bx bx-disc"></i></div>
              <h4 class="title"><a href="">Intervention mobile</a></h4>
              <p class="description">Changement de pneu en mobilité sans modifier l'activité de l'entreprise .</p>
            </div>

            <div class="icon-box" data-aos="fade-up" data-aos-delay="200">
              <div class="icon"><i class="bx bx-atom"></i></div>
              <h4 class="title"><a href="">Un parc automobile connecté </a></h4>
              <p class="description">Des prix négociés pour les pneus de votre flotte. Une interface web sécurisée pour la visualisation et le suivi de tout le parc auto avec des statistiques sur chaque pneu .</p>
            </div>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us" style="text-align: center;">
      <div class="container">

        <div class="section-title" data-aos="zoom-in">
          <!-- <h2>MMP</h2> -->
          <h3>Pourquoi <span>nous choisir </span>?</h3>
          <p style="font-size: 25px;">MMP propose une solution économique et écologique</p>
        </div>

        <div class="row">

          <div class="col-lg-3">
            <div class="box" data-aos="fade-up">
              <h4>25 000 €</h4>
              <p>C'est la dépense supplémentaire que fera une flotte de 50 véhicules pour un non suivi de ses pneumatiques .</p>
              <br><br><br>
              <b>Voulez-vous optimiser votre flotte automobile ?</b>
            </div>
          </div>

          <div class="col-lg-3 mt-4 mt-lg-0">
            <div class="box" data-aos="fade-up" data-aos-delay="100">
              <h4>330 litres</h4>
              <p>de carburant par an, c'est la surconsommation d'un véhicule n'ayant pas de suivi de pression ! <br>
              </p>
                <br><br><br><br>
                <b>Avez-vous un suivi de pression de votre flotte ?</b>
            </div>
          </div>

          <div class="col-lg-3 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
            <div class="box">
              <h4>12 000 km </h4>
              <p>C'est la distance que ne parcouront pas vos pneus à cause d'un remplacement prématuré ! </p>
              <br><br><br><br>
                <b>Connaissez-vous la distance parcourue par vos pneus ?</b>
            </div>
          </div>

          <div class="col-lg-3 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
            <div class="box">
              <h4>3.1 mm</h4>
              <p>c'est l'usure moyenne d'un pneu remplacé alors que la législation autorise
              <b>1.6 mm</b> de hauteur de gomme dans les mêmes conditions de sécurité </p>
              <br><br><br>
              <b>Connaissez-vous l'usure de vos pneus remplacés ?</b>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Counts Section ======= -->
    <!-- <section id="counts" class="counts">
      <div class="container">

        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">250</span>
            <p>Clients satisfaits</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">749</span>
            <p>Vehicules accueillies</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">2,460</span>
            <p>Heures de travail annuel</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-toggle="counter-up">25</span>
            <p>Experts pneumatiques</p>
          </div>

        </div>

      </div>
    </section> --><!-- End Counts Section -->

    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>Prenez RDV dès maintenant. </h3>
          <p></p>
          <a class="cta-btn" href="#contact">Contacter</a>
        </div>

      </div>
    </section><!-- End Cta Section -->

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">

        <div class="section-title" data-aos="zoom-in">
          <!-- <h2>MMP</h2> -->
          <h3>Nos <span>Services</span></h3>
          <p style="font-size: 20px;">La société MMP  innove par un service unique de gestion et de suivi dédié aux pneumatiques afin d'optimiser leurs utilisations</p>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box" data-aos="zoom-in">
              <h4>Un atelier mobile</h4>
              <!-- <h4><a href="">Pression</a></h4> -->
              <p>MMP met en œuvre, grâce à son atelier mobile, toutes les maintenances des pneus en évitant l'immobilisation du véhicule pendant l'activité de l'entreprise.</p>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
              <h4>Des économies</h4>
              <!-- <h4><a href="">Permutation</a></h4> -->
              <p>Les économies liées à cette maintenance sont estimées à plus de 500 euros par an par véhicule.<br>La sécurité des conducteurs est augmentée de façon considérable.</p>
              
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
            <div class="icon-box" data-aos="zoom-in" data-aos-delay="200">
              <h4>Une gestion écoresponsable</h4>
              <!-- <h4><a href="">Remplacement</a></h4> -->
              <p>Ce service unique et innovant permet aux entreprises de faire des économies non négligeables tout en ayant une maintenance écoresponsable et raisonnée des pneus de leur flotte.</p>
            </div>
          </div>

          

        </div>

      </div>
    </section><!-- End Services Section -->

    
    <!-- ======= Team Section ======= -->
    <!-- <section id="team" class="team">
      <div class="container">

        <div class="section-title" data-aos="zoom-in">
          <h2>MMP</h2>
          <h3>Notre <span>Equipe</span></h3>
          <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
        </div>

        <div class="row">

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up">
              <div class="member-img">
                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Nom 1</h4>
                <span>Poste 1</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="100">
              <div class="member-img">
                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Nom 2</h4>
                <span>Poste 2</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="200">
              <div class="member-img">
                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Nom 3</h4>
                <span>Poste 3</span>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
            <div class="member" data-aos="fade-up" data-aos-delay="300">
              <div class="member-img">
                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                <div class="social">
                  <a href=""><i class="icofont-twitter"></i></a>
                  <a href=""><i class="icofont-facebook"></i></a>
                  <a href=""><i class="icofont-instagram"></i></a>
                  <a href=""><i class="icofont-linkedin"></i></a>
                </div>
              </div>
              <div class="member-info">
                <h4>Nom 4</h4>
                <span>Poste 4</span>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section> --><!-- End Team Section -->

    

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title" data-aos="zoom-in">
          <!-- <h2>Contact</h2> -->
          <h3>Nous <span>Contacter</span></h3>
          <p>Pour plus d'informations ou pour demander votre devis, n'hesitez pas à nous contacter. </p>
        </div>

        <div>
          <iframe scrolling="no" marginheight="0" marginwidth="0" width="100%" style="height: 6cm;" src="https://maps.google.com/maps?width=100%25&amp;height=100%&amp;hl=en&amp;q=300%20Avenue%20Antony%20Fabre%2006%20270%20,%20Villeneuve-Loubet,%20France+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"  frameborder="0"></iframe><!-- <a href="https://www.maps.ie/map-my-route/">Draw Route on Google Maps</a> -->
        </div>

        <div class="row mt-5">

          <div class="col-lg-4" data-aos="fade-right">
            <div class="info">
              <div class="address">
                <i class="icofont-google-map"></i>
                <h4>Localisation:</h4>
                <p>300 Avenue Antony Fabre 06270 Villeneuve-Loubet France</p>
              </div>

              <div class="email">
                <i class="icofont-envelope"></i>
                <h4>Email:</h4>
                <p>contactmmp06@gmail.com</p>
              </div>

              <div class="phone">
                <i class="icofont-phone"></i>
                <h4>Telephone :</h4>
                <p>06 82 41 86 92</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0" data-aos="fade-left">

            <!-- <form action="https://mail.google.com/mail/" method="get">
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="view" hidden value="cm">
                  <input type="text" name="fs" hidden="" value="1">
                  <input type="text" name="to"  hidden value="contactmmp06@gmail.com">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Votre nom" data-rule="minlen:4" data-msg="Au moins 4 caractères" />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Votre email" data-rule="email" data-msg="Entrer un email valide" />
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="su" id="subject" placeholder="Sujet" data-rule="minlen:4" data-msg="Au moins 8 caractères" />
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="body" rows="5" data-rule="required" data-msg="Vous devez écrire quelque chose" placeholder="Message"></textarea>
                <div class="validate"></div>
              </div>
              <div class="text-center"><button type="submit">Envoyer</button></div>
            </form> -->
            <form action="/contacter" method="post">
              @csrf
              <div class="form-row">
                <div class="col-md-6 form-group">
                  <input type="text" name="view" hidden value="cm">
                  <input type="text" name="fs" hidden="" value="1">
                  <input type="text" name="to"  hidden value="contactmmp06@gmail.com">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Votre nom" data-rule="minlen:4" data-msg="Au moins 4 caractères" required />
                  <div class="validate"></div>
                </div>
                <div class="col-md-6 form-group">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Votre email" data-rule="email" data-msg="Entrer un email valide" required/>
                  <div class="validate"></div>
                </div>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="su" id="subject" placeholder="Sujet" data-rule="minlen:4" data-msg="Au moins 8 caractères" required/>
                <div class="validate"></div>
              </div>
              <div class="form-group">
                <textarea class="form-control" name="body" rows="5" data-rule="required" data-msg="Vous devez écrire quelque chose" placeholder="Message" required></textarea>
                <div class="validate"></div>
              </div>
              <div class="text-center"><button type="submit" style="background: #d3b85d">Envoyer</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main>
  @endsection
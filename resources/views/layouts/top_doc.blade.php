<header>
    <div class="logo">
      <img src="{{ public_path('assets/img/logo.png') }}" alt="">
    </div>
    <div class="info">
      <p class="first-p">
        {{ $entreprise->raison_sociale }}
      </p>
      <p class="item">
        <span>ice : </span>
        {{ $entreprise->ice }}
      </p>
      <p class="item">
        <span>adresse : </span>
        {{ $entreprise->adresse }}
      </p>
      <p class="item last-p">
        <span>telephone : </span>
        {{ $entreprise->telephone }}
      </p>
    </div>



</header>
<h6>
  {{ $title }}
</h6>
<style>
  header{
    width: 100%;
    margin-top: 0 !important;
    margin-bottom: 2rem;
    height: 5rem;
  }
  /* header .societe{
    width: 60%;
    } */
    header .logo{
      margin: 0;
      width: 40%;
      height: 100%;
      display: inline;
    }
    header .info{
      float: left;
      margin-top: 0;
    margin-left: 12%;
    width: 100%;
  }
  img
  {
    float: left;
    width: 80px;
    margin-right: 9px
  }
  .info .item span{
    margin: 0;
    font-weight: bold;
    text-transform: uppercase;
  }
  .info .item{

    margin-right: 0;
    font-size: 12px;
    margin-bottom: 5px;
  }

  .info p.last-p {
    margin-bottom: 0
  }

  h6{
    text-transform: uppercase;
    letter-spacing: .6px;
    width: 40%;
    margin: .5rem auto;
    border: 1px solid brown;
    text-align: center;
    padding: .5rem 0rem;
    border-radius: .375rem;
  }
</style>
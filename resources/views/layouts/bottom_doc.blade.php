@if (isset($entreprise))
<footer>
    <hr>
    <p class="pagenum-container">
      <span class="fw-bold text-uppercase">
        {{ $entreprise->raison_sociale }}
      </span>
      <br>
      <span class="fw-bold">Siège&nbsp;:&nbsp;</span>{{ $entreprise->adresse }}, {{ $entreprise->ville }}
      <br>
      <span class="fw-bold">IF&nbsp;:&nbsp;</span>{{ $entreprise->if }}
      <span class="fw-bold">ICE&nbsp;:&nbsp;</span>{{ $entreprise->ice }}
      <span class="fw-bold">RC&nbsp;:&nbsp;</span>{{ $entreprise->rc }}
      <span class="fw-bold">PATENTE&nbsp;:&nbsp;</span>{{$entreprise->patente }}
      <span class="fw-bold">CNSS&nbsp;:&nbsp;</span>{{ $entreprise->cnss }}
    </p>
  </footer>

@endif

<style>

hr
{
  margin:0px 0;
  /* height: 1px; */
  background-color: black;
}
footer
{
  position: fixed;
  bottom: 0;
  margin: 0;
  left: 0%;
  width: 100%;


}
footer p{
    margin: 0;
    font-size: 11px;
    letter-spacing: .5px;
    text-align: center;
    line-height: 18px;
  }

footer p span{
    margin: 0;
    font-weight: bold;
  }

</style>
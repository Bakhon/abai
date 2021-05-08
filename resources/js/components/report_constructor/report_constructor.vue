<template>
  <div class="row">
    <div class="col">
      <div class="left-section bg-dark">
        <div class="col">
          <div class="row">
            <div class="left-section-title">
              <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.05078 0.00301123H11.098V5.0498H6.05078V0.00301123Z"
                      fill="#868BB2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10.0743H5.0472V15.1211H0V10.0743Z" fill="#868BB2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6.05078 10.0743H11.098V15.1211H6.05078V10.0743Z"
                      fill="#868BB2"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M3.02602 8.06429H8.07322V9.06934H9.07775V8.06429H14.1249V9.06934H15.1296V7.05973H9.07775V6.05469H8.07322V7.05973H2.02148V9.06934H3.02602V8.06429Z"
                      fill="#868BB2"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12.1035 10.0743H17.1506V15.1211H12.1035V10.0743Z"
                      fill="#868BB2"/>
              </svg>
              Оргструктура
            </div>
            <div class="left-section-title">
              <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M8.26799 19.0107L0 13.1419L1.48826 12.0855L8.25891 16.8896L15.0387 12.0779L16.5361 13.1419L8.26799 19.0107ZM8.26799 15.4307L0 9.56193L1.48826 8.50553L8.25891 13.3097L15.0387 8.49723L16.5361 9.56193L8.26799 15.4307ZM8.26799 11.8508L1.49733 7.04655L0 5.98193L8.26799 0.113119L16.5361 5.98193L15.0292 7.04655L8.26799 11.8508Z"
                      fill="#868BB2"/>
              </svg>
              Геоструктура
            </div>
          </div>
          <div class="row">
            <svg style="margin-right: auto; margin-left: auto;" width="423" height="1" viewBox="0 0 423 1" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1V0H423V1H0Z" fill="#454D7D"/>
            </svg>
          </div>
          <div class="row">
            <div class="left-section-select-area">
              <svg width="16" height="11" viewBox="0 0 16 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M6.38408 10.6943H9.64355V9.06421H6.38408V10.6943ZM0.679688 0.91512V2.54525H15.3479V0.91512H0.679688ZM3.12422 6.61955H12.9034V4.98983H3.12422V6.61955Z"
                      fill="white"/>
              </svg>

              <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="dropdown-inner-text">
                    Выбор объкта
                  </div>
                  <div class="icon-pointer"></div>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </div>
              <svg class="last-element" width="12" height="12" viewBox="0 0 12 12" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path d="M0 0.000249982L4.66665 5.3335V10.6667L7.33335 12V5.33325L12 0H6.00012L0 0.000249982Z"
                      fill="white" fill-opacity="0.3"/>
              </svg>
              <form>
                <input type="text" placeholder="Выбор параметров" id="parametr-search">
                </input>
              </form>
            </div>
          </div>


          <div class="row">
            <div class="col table-wrapper">
              <div class="table-container">
                <div class="table-container-column-header">
                  <div class="row">
                    <div class="my-table-border col-md-2"><div class="centered">12</div></div>
                    <div class="my-table-border col-md-10"><div class="centered">12</div></div>
                  </div>
                </div>
                <div class="table-container-element">
                  <div class="row">
                    <div class="my-table-border col-md-1"><div class="centered">12</div></div>
                    <div class="my-table-border col-md-1"><div class="centered">12</div></div>
                    <div class="my-table-border col-md-10"><div class="centered">12</div></div>
                    </div>
                  <div class="row">
                    <div class="my-table-border col-md-1"><div class="centered">12</div></div>
                    <div class="my-table-border col-md-1"><div class="centered">12</div></div>
                    <div class="my-table-border col-md-10"><div class="centered">12</div></div>
                  </div>




                  </div>


                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    <div class="section-main">
      <div class="col">
        <div class="row">
          <div class="col">
            <section class="section-top  bg-dark">Right TOP</section>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="row">
          <div class="col">
            <section class="section-content bg-dark">
              RIGHT MAIN
            </section>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
$dark-font: #1F2142;
$HarmoniaSansProCyr: "Harmonia Sans Pro Cyr", "Harmonia-sans";
;
body {

  color: white;
}

.left-section {
  width: 441px;

  .left-section-title {
    font-family: $HarmoniaSansProCyr;
    font-weight: 700;
    font-size: 16px;
    line-height: 19px;
    padding: 17px 45px 15px 45px;

    svg {
      margin-right: 10px;
    }
  }

  .dropdown {
  }

  .btn-secondary {
    border: 1px solid #454FA1;
    border-radius: 5px;
    width: 200px;
    height: 30px;
    padding: 6px 0px 5px 10px;
    background: $dark-font;
    font-weight: 400;
    font-size: 16px;
    font-family: $HarmoniaSansProCyr;
    line-height: 19px;
    display: flex;

    .icon-pointer {
      width: 10px;
      height: 10px;
      white-space: nowrap;
      background: url(/img/bd/pointer.svg) 50% 100% no-repeat;
      margin: auto 10px auto auto;
    }

    .dropdown-inner-text {
      text-align: left;
      color: #B6BAD9;
    }
  }

  .dropdown-toggle::after {
    display: none;
  }

  .left-section-select-area {
    margin: 20px 10px;
    width: 100%;
    display: flex;

    .last-element {
      margin-left: auto;
    }

    svg {
      margin-right: 10px;
      margin-top: auto;
      margin-bottom: auto;
    }

    form {
      input[type="text"] {
        width: 159px;
        background: rgba(60, 66, 128, 0.3);
        padding: 6px 8px 5px 9px;
        color: rgba(255, 255, 255, 0.2);
        font-family: $HarmoniaSansProCyr;
        font-weight: 400;
        line-height: 19px;
        font-size: 16px;
        border-radius: 6px;
        border: 0px;
      }
    }
  }


  .table-container {
    background-color: #272953;
    overflow-y: auto;
    overflow-x: auto;
    width: 100%;
    color: white;
    border: 1px solid #454D7D;

    .centered{
      margin: auto;
    }
    .col-md-1{
      padding: 0px;
    }
    .table-container-header {
      text-align: center;
      padding: 14px 20px 0px 20px;
      background-color: #32346C;
    }

    .table-container-column-header {
      text-align: center;
      background-color: #323370;
      height: 38px;

      .row {
        height: 100%;
      }
    }


    .table-container-element {
      height: 340px;
      background-color: #272953;
      border: 1px solid #454D7D;

      .table-container-svg {
        display: flex;
      }

      .svg-element {
        padding: 5px 13px 5px 23px;
        display: grid;

        svg {
          margin-left: auto;
          margin-right: auto;
          margin-top: auto;
          margin-bottom: auto;
        }
      }

      .element-position {
        padding: 5px 13px 5px 23px;
        display: flex;

        p {
          float: right;
          margin-top: auto;
          margin-bottom: auto;
          margin-left: auto;
        }

        .title {
          margin-left: unset;
          margin-right: auto;
        }

        svg {
          margin: auto;
        }
      }

      .row {
        min-height: 38px;

        &:nth-child(2n) {
          background-color: rgba(69, 77, 125, 0.5);
        }
      }
    }

    .row {
      margin-right: 0px;
    }

    .my-table-border{
      border: 1px solid #454D7D;
      display: flex;

      p {
        margin-top: auto;
        margin-bottom: auto;
      }
    }
  }
}

.left-section-table-content {
  display: flex;

  .table-col {

    &:first-child {
      width: 35px;
    }

    &:nth-child(2) {
      width: 35px;
    }

    &:nth-child(3) {
      width: 350px;
    }
  }
}

.section-main {
  width: -webkit-fill-available;
  max-width: calc(100% - 500px);

  .section-top {
    display: table-cell;
  }

  .section-content {
    display: table-cell;
  }
}

.row {
  display: flex;
  color: white;
}

::-webkit-scrollbar-track {
  background: #272953;

}

::-webkit-scrollbar-thumb {
  background: URL("/img/bd/scroll-img.svg") no-repeat 50% #374178;
  height: 10px;
}

::-webkit-scrollbar-button {
  background: URL("/img/bd/scroll-array.svg") no-repeat 50% #485499;

  &:end {
    background: URL("/img/bd/scroll-array-end.svg") no-repeat 50% #485499;
  }
}

</style>


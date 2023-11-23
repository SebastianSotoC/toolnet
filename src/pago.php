<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Formulario de Pago</title>
    <!-- Agregar la referencia a Bootstrap CSS -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    />
  </head>
  <body>
    <div class="container mt-4">
      <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h2 class="card-title text-center">Pago</h2>

              <!-- Botones de selección -->
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-primary active">
                  <input
                    type="radio"
                    name="paymentOption"
                    id="debito"
                    checked
                  />
                  Pago con Débito
                </label>
                <label class="btn btn-primary">
                  <input type="radio" name="paymentOption" id="credito" /> Pago
                  con Crédito
                </label>
              </div>

              <!-- Formulario de Pago con Débito -->
              <form id="debitForm">
                <div class="form-group">
                  <label for="debitName">Nombre:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="debitName"
                    placeholder="Ingrese su nombre"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="debitSurname">Apellido:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="debitSurname"
                    placeholder="Ingrese su apellido"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="debitAddress">Dirección:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="debitAddress"
                    placeholder="Ingrese su dirección"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="debitCardNumber"
                    >Número de Tarjeta de Débito:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="debitCardNumber"
                    placeholder="Ingrese el número de tarjeta"
                    pattern="\d*"
                    maxlength="16"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="debitCvv">CVV:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="debitCvv"
                    placeholder="Ingrese el CVV"
                    pattern="\d{3}"
                    maxlength="3"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="debitFechaVencimiento"
                    >Fecha de Vencimiento:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="debitFechaVencimiento"
                    placeholder="MM/YY"
                    pattern="(0[1-9]|1[0-2])\/\d{2}"
                    maxlength="5"
                    required
                  />
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  Pagar con Débito
                </button>
              </form>

              <!-- Formulario de Pago con Crédito -->
              <form id="creditForm" style="display: none">
                <div class="form-group">
                  <label for="creditName">Nombre:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="creditName"
                    placeholder="Ingrese su nombre"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="creditSurname">Apellido:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="creditSurname"
                    placeholder="Ingrese su apellido"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="creditAddress">Dirección:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="creditAddress"
                    placeholder="Ingrese su dirección"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="creditCardNumber"
                    >Número de Tarjeta de Crédito:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="creditCardNumber"
                    placeholder="Ingrese el número de tarjeta"
                    pattern="\d*"
                    maxlength="16"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="creditCvv">CVV:</label>
                  <input
                    type="text"
                    class="form-control"
                    id="creditCvv"
                    placeholder="Ingrese el CVV"
                    pattern="\d{3}"
                    maxlength="3"
                    required
                  />
                </div>
                <div class="form-group">
                  <label for="creditFechaVencimiento"
                    >Fecha de Vencimiento:</label
                  >
                  <input
                    type="text"
                    class="form-control"
                    id="creditFechaVencimiento"
                    placeholder="MM/YY"
                    pattern="(0[1-9]|1[0-2])\/\d{2}"
                    maxlength="5"
                    required
                  />
                </div>
                <button type="submit" class="btn btn-primary btn-block">
                  Pagar con Crédito
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      function validarTipoTarjeta(numTarjeta) {
        var primerosCuatroDigitos = numTarjeta.substring(0, 4);

        if (/^4/.test(primerosCuatroDigitos)) {
          return 'Visa';
        } else if (/^5[1-5]/.test(primerosCuatroDigitos)) {
          return 'MasterCard';
        } else {
          return 'Desconocido';
        }
      }

      $(document).ready(function () {
        $('input[name="paymentOption"]').on("change", function () {
          if ($("#debito").is(":checked")) {
            $("#debitForm").show();
            $("#creditForm").hide();
          } else {
            $("#debitForm").hide();
            $("#creditForm").show();
          }
        });

        $("#creditCardNumber").on("input", function () {
          var numTarjeta = $(this).val();
          numTarjeta = numTarjeta.replace(/\D/g, "");

          if (numTarjeta.length > 16) {
            numTarjeta = numTarjeta.slice(0, 16);
          }

          var tipoTarjeta = validarTipoTarjeta(numTarjeta);
          $("#tipoTarjeta").text(tipoTarjeta);

          $(this).val(numTarjeta);
        });

        // Validar que solo se puedan ingresar números en los campos de número de tarjeta y CVV
        $("#debitCardNumber, #creditCardNumber, #debitCvv, #creditCvv").on("input", function () {
          this.value = this.value.replace(/\D/g, "");
        });

        // Validar la longitud de la entrada de la tarjeta de crédito y débito en tiempo real
        $("#debitCardNumber, #creditCardNumber").on("input", function () {
          if (this.value.length > 16) {
            this.value = this.value.slice(0, 16);
          }
        });

        // Validar la longitud del CVV en tiempo real
        $("#debitCvv, #creditCvv").on("input", function () {
          if (this.value.length > 3) {
            this.value = this.value.slice(0, 3);
          }
        });

        // Validar la fecha de vencimiento en tiempo real y añadir la barra automáticamente
        $("#debitFechaVencimiento, #creditFechaVencimiento").on("input", function () {
          var input = $(this).val();
          input = input.replace(/[^0-9]/g, "");

          // Insertar la barra automáticamente después de MM
          var newInput = input;
          if (input.length > 2) {
            newInput = input.substring(0, 2) + '/' + input.substring(2);
          }
          $(this).val(newInput);

          // Ajustar la entrada si el usuario intenta introducir más de 5 caracteres
          if (newInput.length > 5) {
            $(this).val(newInput.substring(0, 5));
          }

          // Si el usuario borra el contenido del campo y solo queda una barra, también eliminarla
          if (newInput === '/') {
            $(this).val('');
          }
        });
      });
    </script>
  </body>
</html>

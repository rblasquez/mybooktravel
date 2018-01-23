@extends('layouts.app')

@section('content')
  <section class="container profileContent">

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12 faq">

                    <h1>Preguntas Frecuentes</h1>

                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <h3>Generales</h3>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <h4>¿Cómo se establece el precio de una reserva?</h4>
                                    <p>El precio por noche de cada alojamiento se establece directamente por el
                                        propietario de este, y está relacionado con la ubicación del alojamiento y la cantidad de
                                        atributos que ofrece (número de habitaciones, distribución de camas, estacionamiento,
                                        entre otros), los cuales se encuentran detallados con los íconos que se despliegan al
                                        momento de ingresar a la información de cada propiedad.</p>
                                    <p>Es importante destacar que los precios por noche de cada alojamiento varían en
                                        función de distintos elementos ajenos a MyBookTravel, como por ejemplo el tiempo de
                                        antelación con que se realiza la reserva o el nivel de demanda sobre un alojamiento o
                                        ciudad.</p>
                                    <p>Finalmente, debes saber que los precios mostrados en pantalla ya se encuentran
                                        con todos los cargos administrativos y de impuestos. Si deseas más información sobre
                                        esto conoce más acerca de nuestros Términos y Condiciones.</p>
                                    <h4>¿Cómo funciona el sistema de evaluaciones?</h4>
                                    <p>Al finalizar toda experiencia de alojamiento se envía un breve formulario a ambas partes
                                        para que puedan registrar su evaluación de la misma. Además, todos los huéspedes
                                        podrán dejar sus comentarios, opiniones y tips en los perfiles de los alojamientos en los
                                        cuales hayan estado, y compartir sus experiencias. Si quieres conocer un poco más acerca
                                        de esto, te invitamos a revisar nuestros Términos y Condiciones.</p>
                                    <h4>¿Cómo me contacto con MyBookTravel.com?</h4>
                                    <p>Como somos una comunidad, para nosotros es de suma importancia conocer tu opinión,
                                        por lo cual podrás ponerte en contacto con nosotros en cualquier momento a través de
                                        nuestro chat en línea o de nuestro formulario de contacto, con los cuales (si lo deseas)
                                        podremos gestionar una comunicación telefónica.</p>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingTwo">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <h3>Orientadas al Huésped</h3>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="panel-body">
                                    <h4>¿Cuáles medios de pago puedo utilizar?</h4>
                                    <p>Lo primordial siempre será tu seguridad y comodidad, por lo que, al momento de reservar,
                                        puedes elegir entre Tarjetas de Crédito, Débito, Wester Union o Transferencia bancaria. Es
                                        importante que recuerdes que con los métodos de Wester Union y Transferencia bancaria
                                        debes enviarnos una imagen que compruebe dicha transacción. Si deseas conocer más
                                        detalles, por favor, revisa nuestros Términos y condiciones o contáctanos a través de
                                        nuestro Chat en Línea o Formulario de Contacto.</p>
                                    <h4>¿Cómo puedo cancelar mi reserva?</h4>
                                    <p>Si necesitas anular alguna reserva debes ingresar a “Tu Perfil” y dirigirte a la sección “Mis
                                        Reservas”, donde podrás visualizar cada una de ellas y seleccionar la opción “Cancelar
                                        Reserva”, la anulación de la reserva solo se hará oficial una vez que hagas click en dicha
                                        opción.</p>
                                    <p>Además, es muy importante que revises qué método de cancelación posee el propietario
                                        del alojamiento, puesto que según el método que él haya elegido se definen los plazos en
                                        los que podrás cancelar la reserva y obtener el reembolso total de ésta. Para más detalles,
                                        por favor revisa nuestra sección Métodos de Cancelación de Reserva.</p>
                                    <h4>¿MyBookTravel.com protege mi información?</h4>
                                    <p>Nuestra prioridad siempre es tu seguridad y comodidad, por lo cual, toda la información
                                        que solicitamos se usa para ponernos en contacto contigo ante cualquier eventualidad o
                                        simplemente para mantenerte al tanto de las mejores ofertas, descuentos e
                                        informaciones turísticas de tu interés. Para que puedas conocer más acerca de cómo
                                        manejamos tu información ingresa a nuestras Políticas de Privacidad y Cookies.</p>
                                    <h4>¿Que pasa si las características descritas en el sitio web no coinciden con la realidad?</h4>
                                    <p>En MyBookTravel trabajamos constantemente para asegurar que todo lo publicado
                                        sea verídico y ambas partes puedan disfrutar de esta plataforma, si a pesar de este
                                        esfuerzo llegara a darse está situación es importante que sepas que:</p>
                                    <ol>
                                        <li>- El abono que realizas para concretar la reserva del alojamiento no llega al
                                            propietario hasta que tú hayas confirmado que la reserva cumple con las
                                            características comprometidas.
                                        </li>
                                        <li>- Puedes contactarte con nosotros las 24horas del día, todos los días a través de
                                            nuestro chat on-line, donde con gusto gestionaremos junto a tí cualquier
                                            eventualidad.
                                        </li>
                                        <li>- A través del formulario de evaluación podrás registrar todo lo que te parezca
                                            relevante acerca de la propiedad, para que juntos podamos mejorar nuestro
                                            servicio.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingThree">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        <h3>Orientadas al Propietario</h3>
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="panel-body">
                                    <h4>¿Qué gano publicando en MyBookTravel?</h4>

                                    <ol>
                                        <li>- Tenemos la comisión más baja del mercado, MyBookTravel realiza un cargo del
                                            12% por concepto de gastos de administración por el servicio entregado, el cual solo se
                                            hace efectivo sobre las reservas concretadas.
                                            Mientras tanto, con el registro totalmente gratuito, al publicar a través de nuestra plataforma
                                            podrás:</li>
                                        <li>- Administrar tu calendario de reservas a través de nuestra plataforma, donde podrás
                                            definir de acuerdo a tus necesidades qué fechas tienes disponibles y a qué precio.</li><li>
                                        - Generar más ingresos de forma segura puesto que como mediador MyBookTravel.com
                                        controlará la veracidad de los datos de ambas partes y gestionará los abonos a través
                                        de medios de pago de confianza.</li>
                                        <li>- Controlar tus ingresos, puesto que al utilizar nuestra plataforma ponemos a tu
                                            disposición el registro completo de todos los cobros recibidos y pendientes en la
                                            sección “Mi Dinero” en tu perfil, donde también podrás seleccionar cómo quieres
                                            recibir tales pagos.</li>
                                        <li>- Publicar tus propiedades y llegar a un público mucho más amplio, asegurando la
                                            visibilidad de tu alojamiento en los mercados turísticos más relevantes para tu zona,
                                            aumentando el porcentaje de ocupación de tu alojamiento.</li>
                                    </ol>

                                    <h4>¿Cómo publico mi propiedad?</h4>
                                    <p>Dar a conocer tu propiedad a través de MyBookTravel es muy simple; solo debes
                                        registrarte como usuario y luego, al acceder a tu perfil, seleccionar la opción “Publicar
                                        alojamiento”, donde podrás rellenar el formulario con las características de tu alojamiento.
                                        Recuerda agregar una linda foto y que mientras más completo esté tu formulario, más fácil será
                                        publicitar tu propiedad. Descubre lo fácil que es.</p>
                                    <h4>¿Quiénes podrán reservar mi propiedad?</h4>
                                    <p>Todas las personas que accedan directamente a MyBookTravel y se interesen en tu
                                        propiedad podrán concretar una reserva en ella ¡y no sólo eso! cualquier persona que busque en
                                        internet algún alojamiento con características similares a las de tu propiedad, pueden encontrarla
                                        y reservar, debido a que trabajamos con múltiples herramientas de posicionamiento web. Es por
                                        esto que mientras más completa éste la descripción de tu propiedad, mayor visibilidad podrá
                                        alcanzar.</p>
                                    <p>Además, te aconsejamos mantener siempre actualizado tu calendario con los precios y
                                        fechas disponibles para arrendar, y estar pendiente a las notificaciones de pre- reserva que
                                        puedan llegar a tu correo, para no perder ninguna oportunidad de arriendo.</p>

                                    <h4>Siendo propietario, ¿Puedo modificar o cancelar una reserva ya confirmada?</h4>

                                    <p>Una vez que la reserva ha sido confirmada por parte del anfitrión es responsabilidad de éste
                                        cumplir con el acuerdo y No puede modificar o anular dicha confirmación.</p>
                                    <p>Dado lo anterior te damos la opción de elegir para tus propiedades entre las modalidades de
                                        reserva automática y de Pre-reserva con las cuales buscamos asegurar que puedas cumplir con la
                                        experiencia de alojamiento que te ha confiado el huésped.</p>
                                    <p>Para conocer más información acerca de estas modalidades, por favor ingresa a nuestros Términos
                                        y condiciones.</p>
                                    <h4>¿Cómo recibiré mis pagos?</h4>
                                    <p>Entre las opciones de personalización del servicio, disponible al momento de publicar tu
                                        propiedad en MyBookTravel, puedes elegir cómo quieres recibir tus pagos, si de forma automática
                                        o cada cierto tiempo, acumulando el monto de tus reservas.</p>

                                    <h4>En caso de daños a mi propiedad, ¿Quién se hará cargo?</h4>
                                    <p>Frente a la normativa legal chilena, MyBookTravel no tiene responsabilidad legal sobre daños a la
                                        propiedad. Sin embargo, MyBookTravel puede actuar como mediador entre ambas partes, solo si
                                        es que una de ellas lo solicita expresamente, y siempre estaremos a tu disposición para ayudar a
                                        encontrar una solución que favorezca a todas las partes involucradas.</p>
                                    <p>Además, como nuestra misión es brindarles comodidad, seguridad y tranquilidad a todos nuestros
                                        usuarios, poseemos un fondo para hacer frente a estas eventualidades, siempre y cuando no sea
                                        posible lograr algún acuerdo entre el propietario y el huésped.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </section>

@endsection
import "../../lib/js/custom/indicador-cargando.js"
import { htmlentities } from "../../lib/js/htmlentities.js"
import {
 Sesion
} from "../Sesion.js"
import {
 ROL_ADMINISTRADOR
} from "../const/ROL_ADMINISTRADOR.js"
import {
 ROL_CLIENTE
} from "../const/ROL_CLIENTE.js"

export class MiNav
 extends HTMLElement {

 connectedCallback() {
  this.style.display = "block"
  this.innerHTML = /* HTML */
   `<nav>
     <ul style="display: flex;
            flex-wrap: wrap;
            padding:0;
            gap: 0.5em;
            list-style-type: none">
      <li>
       <indicador-cargando>
       </indicador-cargando>
      </li>
     </ul>
    </nav>`

 }

 /** @param {Sesion} sesion */
 set sesion(sesion) {
  const cue = sesion.cue
  const rolIds = sesion.rolIds
  let innerHTML =
   this.hipervinculoInicio()
  innerHTML +=
   this.hipervinculosAdmin(rolIds)
  innerHTML += this
   .hipervinculosCliente(rolIds)
  innerHTML += this.usuario(cue)
  innerHTML +=
   this.hipervinculoPerfil()
  const ul =
   this.querySelector("ul")
  if (ul !== null) {
   ul.innerHTML = innerHTML
  }
 }

 hipervinculoInicio() {
  return (/* HTML */
   `<li>
     <a href="index.html">
      Inicio</a>
    </li>`)
 }

 /** @param {string} cue */
 usuario(cue) {
  const cueHtml =
   htmlentities(cue)
  return cue === "" ?
   ""
   : /* HTML */
   `<li>${cueHtml}</li>`
 }

 hipervinculoPerfil() {
  return (/* HTML */
   `<li>
     <a href="perfil.html">
       Perfil</a>
    </li>`)
 }

 /** @param {Set<string>} rolIds */
 hipervinculosAdmin(rolIds) {
  return rolIds.
   has(ROL_ADMINISTRADOR) ?
   /* HTML */
   `<li>
     <a href="admin.html">
     Para administradores</a>
    </li>`
   : ""
 }

 /** @param {Set<string>} rolIds */
 hipervinculosCliente(rolIds) {
  return rolIds.has(ROL_CLIENTE) ?
   /* HTML */
   `<li>
     <a href="cliente.html">
     Para clientes</a>
    </li>`
   : ""
 }
}

customElements
 .define("mi-nav", MiNav)
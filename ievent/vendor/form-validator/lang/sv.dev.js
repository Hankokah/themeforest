/**
 * jQuery Form Validator
 * ------------------------------------------
 *
 * Swedish language package
 *
 * @website http://formvalidator.net/
 * @license Dual licensed under the MIT or GPL Version 2 licenses
 * @version 2.2.63
 */
(function($, window) {

  "use strict";

  $(window).bind('validatorsLoaded', function() {

    $.formUtils.LANG = {
      errorTitle: 'Formuläret kunde inte skickas!',
      requiredFields: 'Du har inte besvarat alla frågor',
      badTime: 'Du har inte angett en korrekt tidpunkt',
      badEmail: 'Du har inte angett en korrekt e-postadress',
      badTelephone: 'Du har inte angett ett korrekt telefonnummer',
      badSecurityAnswer: 'Du har angett fel svar på säkerhetsfrågan',
      badDate: 'Du har anget ett felaktigt datum',
      lengthBadStart: 'Ditt svar måste innehålla mellan ',
      lengthBadEnd: ' tecken',
      lengthTooLongStart: 'Du har angett ett svar som är längre än ',
      lengthTooShortStart: 'Du har angett ett svar som är kortare än ',
      notConfirmed: 'Svaren kunde inte bekräfta varandra',
      badDomain: 'Du har angett en inkorrekt domän',
      badUrl: 'Du har inte angett en korrekt webbadress',
      badCustomVal: 'Du har anget ett inkorrekt svar',
      andSpaces: ' och mellanslag ',
      badInt: 'Du har inte angett en siffra',
      badSecurityNumber: 'Du har angett ett felaktigt personnummer',
      badUKVatAnswer: 'Du har inte angett ett brittiskt moms-nummer',
      badStrength: 'Du har angett ett lösenord som inte är nog säkert',
      badNumberOfSelectedOptionsStart: 'Du måste åtminstone välja ',
      badNumberOfSelectedOptionsEnd: ' svarsalternativ',
      badAlphaNumeric: 'Du kan endast svara med alfanumersika tecken (a-z och siffror)',
      badAlphaNumericExtra: ' och ',
      wrongFileSize: 'Filen du försöker ladda upp är för stor (max %s)',
      wrongFileType: 'Endast filer av typen %s är tillåtna',
      groupCheckedRangeStart: 'Välj mellan ',
      groupCheckedTooFewStart: 'Då måste göra minst ',
      groupCheckedTooManyStart: 'Du får inte göra fler än ',
      groupCheckedEnd: ' val',
      badCreditCard: 'Du har angett ett felaktigt kreditkortsnummer',
      badCVV: 'Du har angett ett felaktigt CVV-nummer',
      wrongFileDim : 'Otillåten bildstorlek,',
      imageTooTall : 'bilden får inte vara högre än',
      imageTooWide : 'bilden får inte vara bredare än',
      imageTooSmall : 'bilden är för liten',
      genericBadInputValue : 'The input value can be accepted',
      min : 'minst',
      max : 'max',
      imageRatioNotAccepted : 'Bildens dimensioner (förhållandet mellan höjd och längd) kan inte accepteras'
    };

  });

})(jQuery, window);
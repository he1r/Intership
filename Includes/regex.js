/**
 * REGEX PER TE VALIDUAR TE DHENAT
 */
var onlyLettersRegex = /^[a-zA-Z]+$/;
var onlyNumbersRegex = /^[0-9]+$/;
var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[#$@!%&*?])[A-Za-z\d#$@!%&*?]{8,30}$/
var emailRegex = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/
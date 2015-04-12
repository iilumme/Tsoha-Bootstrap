<?php

class BaseModel {

    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function validateName() {
        $errors = array();
        if ($this->leffanimi == NULL || $this->leffanimi == ' ') {
            $errors[] = 'Nimi ei saa olla tyhjä.';
        }
        return $errors;
    }
    
    public function validateNameForUser() {
        $errors = array();
        if ($this->nimi == NULL || $this->nimi == ' ') {
            $errors[] = 'Nimi ei saa olla tyhjä.';
        }
        return $errors;
    }
    
    public function validateUsername() {
        $errors = array();
        if ($this->kayttajatunnus == NULL || $this->kayttajatunnus == ' '|| strlen($this->kayttajatunnus) < 4) {
            $errors[] = 'Tunnus ei saa olla tyhjä eikä alle neljä merkkiä pitkä.';
        }
        return $errors;
    }
    
    public function validatePassword() {
        $errors = array();
        if ($this->salasana == NULL || $this->salasana == ' ' || strlen($this->salasana) < 5) {
            $errors[] = 'Salasana ei saa olla tyhjä eikä alle viisi merkkiä pitkä.';
        }
        return $errors;
    }

    public function validateYear() {
        $errors = array();
        if ($this->vuosi <= 1800 || $this->vuosi > 2100 || !is_numeric($this->vuosi)) {
            $errors[] = 'Tarkista vuosi.';
        }
        return $errors;
    }

    public function validateBirthYear() {
        $errors = array();
        if (($this->syntymavuosi <= 1800 && $this->syntymavuosi != 0 ) || $this->syntymavuosi > 2100 || !is_numeric($this->syntymavuosi)) {
            $errors[] = 'Tarkista syntymävuosi.';
        }
        return $errors;
    }

    public function validateLanguage() {
        $errors = array();
        if ($this->kieli == NULL || $this->kieli == ' ') {
            $errors[] = 'Kieli ei voi olla tyhjä.';
        }
        return $errors;
    }

    public function validateFirstName() {
        $errors = array();
        if ($this->etunimi == NULL || $this->etunimi == ' ') {
            $errors[] = 'Etunimi ei saa olla tyhjä.';
        }
        return $errors;
    }

    public function validateLastName() {
        $errors = array();
        if ($this->sukunimi == NULL || $this->sukunimi == ' ') {
            $errors[] = 'Sukunimi ei saa olla tyhjä.';
        }
        return $errors;
    }

    public function errors() {
        $errors = array();

        foreach ($this->validators as $validator) {
            $val = $validator;
            $errors = array_merge($errors, $this->{$val}());
        }

        return $errors;
    }

}

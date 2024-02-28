# Zadanie rekrutacyjne slowhop

## Treść
1. Stwórz końcówkę REST, w ramach której pobierzesz plik iCal zwrócisz odpowiedź w formacie JSON lub XML (obojętnie), gdzie dla każdego eventu zwrócisz informacje: id, start, end i summary (przykład odpowiedzi: https://gist.github.com/pkalisz/daae919cb6c0714a116caedb37ca2315).
2. Stwórz polecenie konsolowe (Command), które po odpaleniu zrobi dokładnie to samo co końcówka RESTowa z punktu 1 i wypluje wynik na ekran
3. Zdockeryzuj ten mikroserwis, idealnie będzie jeśli będę mógł go odpalić przy pomocy “docker compose”
4. Napisz jakiś prosty unit test
5. Użyj PHP w wersji 7+
6. Buduj serwis z myślą o utrzymaniu go na produkcji, pamiętaj o czytelnym kodzie, logach, etc..
7. <b>BONUS: Wynik działania końcówki z p1 i commanda z p2 zrzuć do pliku i zapisz ten plik w S3.</b>

---

1. Końcówka REST wystawiona jest na domyślnym adresie: http://localhost:8070/ w formacie JSON.
2. Utworzona komenda to `calendar:event`, pełna komenda znajdując się w folderze głównym wygląda tak: `php symfony/bin/console calendar:event`.
3. Mikroserwis został w pełni zdockeryzowany, do włączenia go wystarczy prosty `docker compose up -d --build`, domyślnie wystawiony jest port: 8070.
4. Unit test jest bardzo prosty i testuje generowanie pliku z linku a także sprawdza czy zawartość zapisanego pliku jest taka sama jak w przekazanym mocku.
5. Użyta została wersja 8.2-fpm.
6. Włączone zostały również logi a także dodane zostało logowanie każdego URL użytego w komendzie z punktu 2.
7. <b>BONUS: Wyniki z p1 i p2 automatycznie wrzucają się na S3, dodatkowo używając komendy z punktu 2. wyświetlany jest bezpośredni link do wrzuconego pliku.(Po ustawieniu secret key w .env który wysłałem mailem)</b>


# Instalacja

```sh
docker compose up -d --build
```
Domyślny adres: http://localhost:8070/

### Komenda z punktu 2

```sh
php symfony/bin/console calendar:event
```
Dodatkowo wyświetla link do właśnie przetworzonego i wrzuconego pliku na S3.
### Testy jednostkowe

```sh
docker compose exec app php vendor/bin/phpunit
```

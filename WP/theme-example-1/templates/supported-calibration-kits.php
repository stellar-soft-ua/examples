<?php
/**
 * Template Name: Supported Calibration Kits
 */

get_header();
?>

<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <?php the_content(); ?>
<?php endwhile; endif; ?>
<section class="calibration-service">
    <div class="container">

        <select id="selectField">
            <option selected disabled value> Select Provider</option>
            <option value="All">All</option>
            <option value="CMT">CMT</option>
            <option value="Agilent">Agilent</option>
            <option value="Rosenberger">Rosenberger</option>
            <option value="FlannMicrowave">Flann Microwave</option>
            <option value="MauryMicrowave">Maury Microwave</option>
            <option value="Rohde">Rohde & Schwarz</option>
            <option value="Miscellaneous">Miscellaneous</option>

        </select>
        <table class="table table--calibration-service" id="myTable">
            <thead>
            <tr>
                <th>KIT</th>
                <th>DESCRIPTION</th>
            </tr>
            </thead>
            <tbody>
            <tr style="display: none">
                <td>N1.1 (Female)</td>
                <td>Type-N 50Ω 1.5GHz Cal Kit (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N1.1 (Female)</td>
                <td>Type-N 50Ω 1.5GHz Cal Kit (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N1.1 (Male)</td>
                <td>Type-N 50Ω 1.5GHz Cal Kit (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N611/12</td>
                <td>Type-N 50Ω 6GHz Cal Kit, S/N 4xx,5xx,6xx (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N611/12/911/12</td>
                <td>Type-N 50Ω 6GHz/9GHz Cal Kit, S/N Axx, Bxx (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N611</td>
                <td>Type-N 50Ω 6GHz Cal Kit, S/N 4xx,5xx,6xx (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N611/911</td>
                <td>Type-N 50Ω 6GHz/9GHz Cal Kit, S/N Axx, Bxx (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N612</td>
                <td>Type-N 50Ω 6GHz Cal Kit, S/N 4xx,5xx,6xx (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>N612/912</td>
                <td>Type-N 50Ω 6GHz/9GHz Cal Kit, S/N Axx, Bxx (CMT)</td>
            </tr>
            <tr provider="CMT">
                <td>F7511</td>
                <td>Type-F 75Ω 3GHz Cal Kit (CMT)</td>
            </tr>
            <tr provider="Agilent">
                <td>8050B</td>
                <td>Type-F 75Ω 3GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85032B/E</td>
                <td>Type-N 50Ω 6GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85032B (Female)</td>
                <td>Type-N 50Ω 6GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85032B (Male)</td>
                <td>Type-N 50Ω 6GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85032F</td>
                <td>Type-N 50Ω 9GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85032F (Female)</td>
                <td>Type-N 50Ω 9GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85032F (Male)</td>
                <td>Type-N 50Ω 9GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85033D/E</td>
                <td>3.5 mm 6GHz/9GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85033D/E (Female)</td>
                <td>3.5 mm 6GHz/9GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85033D/E (Male)</td>
                <td>3.5 mm 6GHz/9GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85036B (Female)</td>
                <td>Type-N 75Ω 3GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85036B (Male)</td>
                <td>Type-N 75Ω 3GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85036B/E</td>
                <td>Type-N 75Ω 3GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85039B</td>
                <td>Type-F 75Ω 3GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85050B</td>
                <td>7 mm 18GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85052B</td>
                <td>3.5 mm 26.5GHz Cal Kit with Sliding Load (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85052C</td>
                <td>3.5 mm 26.5GHz SOLT/TRL Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85052D</td>
                <td>3.5 mm 26.5GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85054B</td>
                <td>Type-N 50Ω 18GHz Cal Kit with Sliding Load (Agilent)</td>
            </tr>
            <tr provider="Agilent">
                <td>85054D</td>
                <td>Type-N 50Ω 18GHz Cal Kit (Agilent)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>03CK10A-150</td>
                <td>3.5 mm 26.5GHz Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>03CK10A-150 (Female)</td>
                <td>3.5 mm 26.5GHz Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>03CK10A-150 (Male)</td>
                <td>3.5 mm 26.5GHz Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>05CK10A-150</td>
                <td>Type-N 50Ω 18GHz Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>05CK10A-150 (Female)</td>
                <td>Type-N 50Ω 18GHz Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>05CK10A-150 (Male)</td>
                <td>Type-N 50Ω 18GHz Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="Rosenberger">
                <td>05CK120-150</td>
                <td>Type-N 50Ω 18GHz LRL/LRM Cal Kit (Rosenberger)</td>
            </tr>
            <tr provider="FlannMicrowave">
                <td>WR137</td>
                <td>C-band 5.38-8.18G Waveguide (Flann Microwave)</td>
            </tr>
            <tr provider="FlannMicrowave">
                <td>WR159</td>
                <td>F-band 4.64-7.05G Waveguide (Flann Microwave)</td>
            </tr>
            <tr provider="FlannMicrowave">
                <td>WR187</td>
                <td>G-band 3.94-5.99G Waveguide (Flann Microwave)</td>
            </tr>
            <tr provider="FlannMicrowave">
                <td>WR229</td>
                <td>E-band 3.3-4.9G Waveguide (Flann Microwave)</td>
            </tr>
            <tr provider="FlannMicrowave">
                <td>WR284</td>
                <td>S-band 2.6-3.95G Waveguide (Flann Microwave)</td>
            </tr>
            <tr provider="MauryMicrowave">
                <td>8050A/Y</td>
                <td>3.5 mm 34GHz Cal Kit with Sliding Load (Maury Microwave)</td>
            </tr>
            <tr provider="MauryMicrowave">
                <td>8850C</td>
                <td>Type-N 50Ω 18GHz Cal Kit with Sliding Load (Maury Microwave)</td>
            </tr>
            <tr provider="MauryMicrowave">
                <td>8850P/Q</td>
                <td>Type-N 50Ω 18GHz Cal Kit (Maury Microwave)</td>
            </tr>
            <tr provider="MauryMicrowave">
                <td>8860A</td>
                <td>Type-N 50Ω 18GHz TRM/TRL/LRL Cal Kit (Maury Microwave)</td>
            </tr>
            <tr provider="MauryMicrowave">
                <td>8880A/B</td>
                <td>Type-N 75Ω 2GHz Cal Kit (Maury Microwave)</td>
            </tr>
            <tr provider="MauryMicrowave">
                <td>8580S F</td>
                <td>75Ω Cal Kit (Maury Microwave)</td>
            </tr>
            <tr provider="Rohde">
                <td>ZV-Z135</td>
                <td>3.5 mm 15GHz Cal Kit (Rohde Schwarz)</td>
            </tr>
            <tr provider="Rohde">
                <td>FSH-Z29</td>
                <td>Type-N 50Ω Cal Kit (Rohde Schwarz)</td>
            </tr>
            <tr>
                <td>Ideal</td>
                <td>Ideal 50 Ohm SOLT Cal Kit</td>
            </tr>
            <tr>
                <td>STMFL275</td>
                <td>StMicro TRL board - GoPro - STMFL275 DIP2450-01D3</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
<?php wp_enqueue_script('cmt-table-filter', get_template_directory_uri() . '/assets/js/table-filter.js', [], null,
    true); ?>
<?php get_footer(); ?>


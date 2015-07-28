<?php

/**
 * Seo.class.php [MODEL]
 * Classe de apoio para o modelo LINK. Pode ser utilizada para gerar SSEO para as páginas do sistem!
 * 
 * @copyright (c) 2015, Adriano S. Reis Programador
 */
class Seo {

    private $File;
    private $Link;
    private $Data;
    private $Tags;

    /* DADOS POVOADOS */
    private $seoTags;
    private $seoData;

    function __construct($File, $Link) {
        $this->File = strip_tags(trim($File));
        $this->Link = strip_tags(trim($Link));
    }

    public function getTags() {
        $this->checkData();
        return $this->seoTags;
    }

    public function getData() {
        $this->checkData();
        return $this->seoData;
    }

    /**
     * ****************************************
     * *************** PRIVATES ***************
     * ****************************************
     */
    private function checkData() {
        if (!$this->seoData):
            $this->getSeo();
        endif;
    }

    private function getSeo() {

        switch ($this->File):
            //SEO:: ARTIGO
            case 'artigo':
                $Admin = (isset($_SESSION['userlogin']['user_level']) && $_SESSION['userlogin']['user_level'] == 3 ? true : false);
                $Check = ($Admin ? '' : 'post_status = 1 AND ');

                $ReadSeo = new WsPosts;
                $ReadSeo->setPost_name($this->Link);
                $ReadSeo->Execute()->Query("{$Check} #post_name#");

                if (!$ReadSeo->Execute()->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    extract((array) $ReadSeo->Execute()->getResult()[0]);
                    $this->seoData = (array) $ReadSeo->Execute()->getResult()[0];
                    $this->Data = [$post_title . ' - ' . SITENAME, $post_content, HOME . "/artigo/{$post_name}", HOME . "/uploads/{$post_cover}"];

                    //post:: conta viws do post
                    $ReadSeo->setPost_id($post_id);
                    $ReadSeo->setPost_views($post_views + 1);
                    $ReadSeo->setPost_last_views(date('Y-m-d H:i:s'));
                    $ReadSeo->Execute()->update($ReadSeo->Execute()->getDados(), 'post_id');
                endif;
                break;
            //SEO:: CATEGORIA
            case 'categoria':
                $ReadSeo = new WsCategories;
                $ReadSeo->setCategory_name($this->Link);
                $ReadSeo->Execute()->Query("#category_name#");

                if (!$ReadSeo->Execute()->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    extract((array) $ReadSeo->Execute()->getResult()[0]);
                    $this->seoData = (array) $ReadSeo->Execute()->getResult()[0];
                    $this->Data = [$category_title . ' - ' . SITENAME, $category_content, HOME . "/categoria/{$category_name}", INCLUDE_PATH . '/images/site.png'];

                    //categories:: conta views da categoria
                    $ReadSeo->setCategory_id($category_id);
                    $ReadSeo->setCategory_views($category_views + 1);
                    $ReadSeo->setCategory_last_view(date('Y-m-d H:i:s'));
                    $ReadSeo->Execute()->update($ReadSeo->Execute()->getDados(), 'category_id');
                endif;
                break;
            //SEO::PESQUISA
            case 'pesquisa':
                $ReadSeo = new WsPosts;
                $ReadSeo->Execute()->Query("post_status = 1 AND (post_title LIKE '%' :link '%' OR post_content LIKE '%' :link '%')", "link={$this->Link}");

                if (!$ReadSeo->Execute()->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    $this->seoData['count'] = $ReadSeo->Execute()->getRowCount();
                    $this->Data = ["Pesquisa por: \"{$this->Link}\"" . ' - ' . SITENAME, "Sua pesquisa por {$this->Link} retornou {$this->seoData['count']} resultados!", HOME . "/pesquisa/{$this->Link}", INCLUDE_PATH . '/images/site.png'];
                endif;
                break;

            //SEO:: EMPRESAS
            case 'empresas':
                $Name = ucwords(str_replace("-", " ", $this->Link));
                $this->seoData = ['empresa_link' => $this->Link, 'empresa_cat' => $Name];
                $this->Data = ["Empresas {$this->Link}" . SITENAME, "Confira o guia completo de sua cidade, e encontra empresas {$this->Link}", HOME . '/empresas/' . $this->Link, INCLUDE_PATH . '/images/site.png'];
                break;

            //SEO:: EMPRESA SINGLE
            case 'empresa':
                $Admin = (isset($_SESSION['userlogin']['user_level']) && $_SESSION['userlogin']['user_level'] == 3 ? true : false);
                $Check = ($Admin ? '' : 'empresa_status = 1 AND ');

                $ReadSeo = new AppEmpresas();
                $ReadSeo->setEmpresa_name($this->Link);
                $ReadSeo->Execute()->Query("{$Check} #empresa_name#");

                if (!$ReadSeo->Execute()->getResult()):
                    $this->seoData = null;
                    $this->seoTags = null;
                else:
                    extract((array) $ReadSeo->Execute()->getResult()[0]);
                    $this->seoData = (array) $ReadSeo->Execute()->getResult()[0];
                    $this->Data = [$empresa_title . ' - ' . SITENAME, $empresa_sobre, HOME . "/empresa/{$empresa_name}", HOME . "/uploads/{$empresa_capa}"];

                    //empresa:: conta views da empresa
                    $ReadSeo->setEmpresa_id($empresa_id);
                    $ReadSeo->setEmpresa_views($empresa_views + 1);
                    $ReadSeo->setEmpresa_last_view(date('Y-m-d H:i:s'));
                    $ReadSeo->Execute()->update($ReadSeo->Execute()->getDados(), 'empresa_id');
                endif;
                break;

            //SEO:: CADASTRA EMPRESA
            case 'cadastra-empresa':
                $this->Data = ["Cadastre sua Empresa - " . SITENAME, "Página modelo para cadastro de empresas via Front-End do curso Work Series - PHP Orientado a Objetos!", HOME . '/cadastra-empresa/' . $this->Link, INCLUDE_PATH . '/images/site.png'];
                break;

            //SEO:: INDEX
            case 'index':
                $this->Data = [SITENAME . ' - Seu Guia de empresas, eventos e baladas!', SITEDESC, HOME, INCLUDE_PATH . '/images/site.png'];
                break;

            //SEO:: 404
            default :
                $this->Data = ['404 Oppss, Nada encontrado!', SITEDESC, HOME . '/404', INCLUDE_PATH . '/images/site.png'];
                break;

        endswitch;

        if ($this->Data):
            $this->setTags();
        endif;
    }

    private function setTags() {
        $this->Tags['Title'] = $this->Data[0];
        $this->Tags['Content'] = Check::Words(html_entity_decode($this->Data[1]), 25);
        $this->Tags['Link'] = $this->Data[2];
        $this->Tags['Image'] = $this->Data[3];
        $this->Tags = array_map('strip_tags', $this->Tags);
        $this->Tags = array_map('trim', $this->Tags);

        $this->Data = null;

        //NORMAL PAGE
        $this->seoTags = "<title>{$this->Tags['Title']}</title>" . "\n";
        $this->seoTags .= "<meta name='description' content='{$this->Tags['Content']}'/>" . "\n";
        $this->seoTags .= "<meta name='robots' content='index, fallow'/>" . "\n";
        $this->seoTags .= "<link rel='canonical' href='{$this->Tags['Link']}'>" . "\n";
        $this->seoTags .= "\n";

        //FACEBOOK
        $this->seoTags .= "<meta property='og:site_name' content='" . SITENAME . "' />" . "\n";
        $this->seoTags .= "<meta property='og:locale' content='pt-BR' />" . "\n";
        $this->seoTags .= "<meta property='og:title' content='{$this->Tags['Title']}' />" . "\n";
        $this->seoTags .= "<meta property='og:description' content='{$this->Tags['Content']}' />" . "\n";
        $this->seoTags .= "<meta property='og:image' content='{$this->Tags['Image']}' />" . "\n";
        $this->seoTags .= "<meta property='og:url' content='{$this->Tags['Link']}' />" . "\n";
        $this->seoTags .= "<meta property='og:type' content='article' />" . "\n";
        $this->seoTags .= "" . "\n";

        //Item GROUP (TWITTER)
        $this->seoTags .= "<meta itemprop='name' content='{$this->Tags['Title']}' />" . "\n";
        $this->seoTags .= "<meta itemprop='description' content='{$this->Tags['Content']}' />" . "\n";
        $this->seoTags .= "<meta itemprop='url' content='{$this->Tags['Link']}' />" . "\n";

        $this->Tags = null;
    }

}

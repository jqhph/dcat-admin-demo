<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection roles
     * @property Grid\Column|Collection permissions
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection user
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection action
     * @property Grid\Column|Collection middleware
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection description
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection cost
     * @property Grid\Column|Collection avgMonthCost
     * @property Grid\Column|Collection avgQuarterCost
     * @property Grid\Column|Collection avgYearCost
     * @property Grid\Column|Collection avgMonthVist
     * @property Grid\Column|Collection avgQuarterVist
     * @property Grid\Column|Collection avgYearVist
     * @property Grid\Column|Collection incrs
     * @property Grid\Column|Collection avgVists
     * @property Grid\Column|Collection topCost
     * @property Grid\Column|Collection topVist
     * @property Grid\Column|Collection topIncr
     * @property Grid\Column|Collection date
     * @property Grid\Column|Collection label
     * @property Grid\Column|Collection progressBar
     * @property Grid\Column|Collection expand
     * @property Grid\Column|Collection select
     * @property Grid\Column|Collection switch
     * @property Grid\Column|Collection switchGroup
     * @property Grid\Column|Collection editable
     * @property Grid\Column|Collection checkbox
     * @property Grid\Column|Collection radio
     * @property Grid\Column|Collection title
     * @property Grid\Column|Collection images
     * @property Grid\Column|Collection year
     * @property Grid\Column|Collection rating
     * @property Grid\Column|Collection directors
     * @property Grid\Column|Collection casts
     * @property Grid\Column|Collection genres
     * @property Grid\Column|Collection app
     * @property Grid\Column|Collection homepage
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection roles(string $label = null)
     * @method Grid\Column|Collection permissions(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection user(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection action(string $label = null)
     * @method Grid\Column|Collection middleware(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection description(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection cost(string $label = null)
     * @method Grid\Column|Collection avgMonthCost(string $label = null)
     * @method Grid\Column|Collection avgQuarterCost(string $label = null)
     * @method Grid\Column|Collection avgYearCost(string $label = null)
     * @method Grid\Column|Collection avgMonthVist(string $label = null)
     * @method Grid\Column|Collection avgQuarterVist(string $label = null)
     * @method Grid\Column|Collection avgYearVist(string $label = null)
     * @method Grid\Column|Collection incrs(string $label = null)
     * @method Grid\Column|Collection avgVists(string $label = null)
     * @method Grid\Column|Collection topCost(string $label = null)
     * @method Grid\Column|Collection topVist(string $label = null)
     * @method Grid\Column|Collection topIncr(string $label = null)
     * @method Grid\Column|Collection date(string $label = null)
     * @method Grid\Column|Collection label(string $label = null)
     * @method Grid\Column|Collection progressBar(string $label = null)
     * @method Grid\Column|Collection expand(string $label = null)
     * @method Grid\Column|Collection select(string $label = null)
     * @method Grid\Column|Collection switch(string $label = null)
     * @method Grid\Column|Collection switchGroup(string $label = null)
     * @method Grid\Column|Collection editable(string $label = null)
     * @method Grid\Column|Collection checkbox(string $label = null)
     * @method Grid\Column|Collection radio(string $label = null)
     * @method Grid\Column|Collection title(string $label = null)
     * @method Grid\Column|Collection images(string $label = null)
     * @method Grid\Column|Collection year(string $label = null)
     * @method Grid\Column|Collection rating(string $label = null)
     * @method Grid\Column|Collection directors(string $label = null)
     * @method Grid\Column|Collection casts(string $label = null)
     * @method Grid\Column|Collection genres(string $label = null)
     * @method Grid\Column|Collection app(string $label = null)
     * @method Grid\Column|Collection homepage(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection name
     * @property Show\Field|Collection roles
     * @property Show\Field|Collection permissions
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection user
     * @property Show\Field|Collection method
     * @property Show\Field|Collection path
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection action
     * @property Show\Field|Collection middleware
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection description
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection content
     * @property Show\Field|Collection status
     * @property Show\Field|Collection cost
     * @property Show\Field|Collection avgMonthCost
     * @property Show\Field|Collection avgQuarterCost
     * @property Show\Field|Collection avgYearCost
     * @property Show\Field|Collection avgMonthVist
     * @property Show\Field|Collection avgQuarterVist
     * @property Show\Field|Collection avgYearVist
     * @property Show\Field|Collection incrs
     * @property Show\Field|Collection avgVists
     * @property Show\Field|Collection topCost
     * @property Show\Field|Collection topVist
     * @property Show\Field|Collection topIncr
     * @property Show\Field|Collection date
     * @property Show\Field|Collection label
     * @property Show\Field|Collection progressBar
     * @property Show\Field|Collection expand
     * @property Show\Field|Collection select
     * @property Show\Field|Collection switch
     * @property Show\Field|Collection switchGroup
     * @property Show\Field|Collection editable
     * @property Show\Field|Collection checkbox
     * @property Show\Field|Collection radio
     * @property Show\Field|Collection title
     * @property Show\Field|Collection images
     * @property Show\Field|Collection year
     * @property Show\Field|Collection rating
     * @property Show\Field|Collection directors
     * @property Show\Field|Collection casts
     * @property Show\Field|Collection genres
     * @property Show\Field|Collection app
     * @property Show\Field|Collection homepage
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection order
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection password
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection roles(string $label = null)
     * @method Show\Field|Collection permissions(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection user(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection action(string $label = null)
     * @method Show\Field|Collection middleware(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection description(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection cost(string $label = null)
     * @method Show\Field|Collection avgMonthCost(string $label = null)
     * @method Show\Field|Collection avgQuarterCost(string $label = null)
     * @method Show\Field|Collection avgYearCost(string $label = null)
     * @method Show\Field|Collection avgMonthVist(string $label = null)
     * @method Show\Field|Collection avgQuarterVist(string $label = null)
     * @method Show\Field|Collection avgYearVist(string $label = null)
     * @method Show\Field|Collection incrs(string $label = null)
     * @method Show\Field|Collection avgVists(string $label = null)
     * @method Show\Field|Collection topCost(string $label = null)
     * @method Show\Field|Collection topVist(string $label = null)
     * @method Show\Field|Collection topIncr(string $label = null)
     * @method Show\Field|Collection date(string $label = null)
     * @method Show\Field|Collection label(string $label = null)
     * @method Show\Field|Collection progressBar(string $label = null)
     * @method Show\Field|Collection expand(string $label = null)
     * @method Show\Field|Collection select(string $label = null)
     * @method Show\Field|Collection switch(string $label = null)
     * @method Show\Field|Collection switchGroup(string $label = null)
     * @method Show\Field|Collection editable(string $label = null)
     * @method Show\Field|Collection checkbox(string $label = null)
     * @method Show\Field|Collection radio(string $label = null)
     * @method Show\Field|Collection title(string $label = null)
     * @method Show\Field|Collection images(string $label = null)
     * @method Show\Field|Collection year(string $label = null)
     * @method Show\Field|Collection rating(string $label = null)
     * @method Show\Field|Collection directors(string $label = null)
     * @method Show\Field|Collection casts(string $label = null)
     * @method Show\Field|Collection genres(string $label = null)
     * @method Show\Field|Collection app(string $label = null)
     * @method Show\Field|Collection homepage(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     * @method \Dcat\Admin\Form\Field\Button button(...$params)
     * @method \Dcat\Admin\Extension\UEditor\Form\UEditor ueditor(...$params)
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     * @method $this code(...$params)
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

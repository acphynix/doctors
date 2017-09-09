<div class="row db-page">
    <div class="col-xs-12 p-title">
        <h4 class="text-center">
            <b>
                <i class="fa fa-user"></i> PROFILE
            </b>
        </h4>
        <div class="u-line"></div>
    </div>
    <div class="col-xs-12 p-content">
        <div class="row">
            <div class="col-md-4 profile-pic">
                <img ng-src="{{user.image}}" class="img-responsive" alt="user_image"/>
                <div class="text-left">
                    <h4>{{user.name}}</h4>
                    <p class="text-info">{{user.email}}</p>
                </div>
            </div>
            <div class="col-md-8 profile-form">
                <form id='form_profile'>
                    <ul id='errorPr' class="pc-error"></ul>
                    <table class="">
                        <tbody ng-repeat='f in profile_form_fields'>
                            <tr ng-show="{{f.heading != ''}}">
                                <td colspan='3'>&nbsp;</td>
                            </tr>
                            <tr>
                                <td><b class="text-info visible-md visible-lg">{{f.heading}}</b></td>
                                <td><span class="text-right field-label">{{f.title}}:</span></td>
                                <td>
                                    <input ng-attr-id="{{f.id}}" ng-attr-type="{{f.type}}"
                                           ng-attr-name="{{f.name}}" ng-attr-value="{{f.value}}"
                                           ng-disabled='{{f.disabled}}' class="form-control"/>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
                    <hr/>
                    <input type='submit' value='Save Changes' name='Save Changes' class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
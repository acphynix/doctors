<div style='width:100%;text-align:center;margin-top:2em;margin:0'>
  <div style='width:80%;min-width:35em;display:inline-block;text-align:left'>
    <div style='display:block;width:100%;padding:2em'>
      <div style="border:2px black solid;background-image:url({{user.image}});background-size:cover;width:8em;height:8em;margin-left:0;margin-right:1em;display:inline-block;float:left">
      </div>
      <div style='display:inline-block;padding-bottom:2em;margin-left:0;margin-top:0'>
        <div style='padding:0;margin:0;font-family:cabin;font-size:1.5em'>{{user.name}}</div>
        <div style='padding:0;margin:0;font-family:cabin'>{{user.email}}</div>
        <div style='padding:0;margin:0;font-family:cabin'>{{user.role}}</div>
      </div>
    </div>
    <hr />
    <form id='form_profile'>
      <table>
      <tbody ng-repeat='f in profile_form_fields'>
        <tr ng-show="{{f.heading != ''}}">
          <td colspan='3'>&nbsp;</td>
        </tr>
        <tr>
          <td>{{f.heading}}</td>
          <td>{{f.title}}</td>
          <td><input ng-attr-id="{{f.id}}" ng-attr-type="{{f.type}}" ng-attr-name="{{f.name}}" ng-attr-value="{{f.value}}" ng-disabled='{{f.disabled}}' /></td>
        </tr>
      </tbody>
      <tbody>
        <tr>
          <td></td>
          <td><input type='submit'></td>
          <td></td>
        </tr>
      </tbody>
      </table>
    </form>
  </div>
</div>
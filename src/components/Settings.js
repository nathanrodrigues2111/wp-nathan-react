import React, { useState, useEffect } from 'react';
import axios from 'axios';

const Settings = () => {  

    const [ enableTheme, setEnableTheme ] = useState(false);
    const [ selectedTheme, setSelectedTheme ] = useState('regular');
    const [ loader, setLoader ] = useState( 'Save Settings' );

    const url = `${appLocalizer.apiUrl}/wpnat/v1/settings`;

    const handleSubmit = (e) => {
        e.preventDefault();
        setLoader( 'Saving...' );
        axios.post( url, {
            enable_comments: enableTheme,
            selected_theme: selectedTheme,
        }, {
            headers: {
                'content-type': 'application/json',
                'X-WP-NONCE': appLocalizer.nonce
            }
        } )
        .then( ( res ) => {
            setLoader( 'Save Settings' );
        } )
    }

    useEffect( () => { 
        axios.get( url )
        .then( ( res ) => {
            setEnableTheme( res.data.enable_comments );
            setSelectedTheme( res.data.selected_theme );
        } )
    }, [] )

    return(
        <React.Fragment>
            <h1>{appLocalizer.pluginTitle}</h1>
            <form onSubmit={ (e) => handleSubmit(e) }>
                <table className="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">Enable comment styles</th>
                            <td>
                                <label htmlFor="enable_comment_styles">
                                    <input name="enable_comment_styles"
                                    type="checkbox"
                                    id="enable_comment_styles"
                                    checked={enableTheme}
                                    onChange={() => setEnableTheme(!enableTheme)}
                                    />	Enable this option to style the default comments section on your site
                                </label>
                            </td>
                        </tr>

                        <tr className="toggle-comment-settings" style={{ display: enableTheme ? '' : 'none' }}>
                            <th scope="row">
                                <label htmlFor="default_comments_theme">Comment theme</label>
                            </th>
                            <td>
                            <select name="default_comments_theme" id="default_comments_theme" value={selectedTheme} onChange={(e) => setSelectedTheme(e.target.value)}>
                                <option value="regular">Regular theme</option>
                                <option value="modern">Modern theme</option>
                                <option value="twitter">Twitter theme</option>
                                <option value="discord">Discord theme</option>
                            </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p className="submit">
                    <button type="submit" className="button button-primary">{ loader }</button>
                </p>
            </form>
        </React.Fragment>
    )
}

export default Settings;
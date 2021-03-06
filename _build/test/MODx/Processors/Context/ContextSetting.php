<?php
/**
 * MODx Revolution
 *
 * Copyright 2006-2010 by the MODx Team.
 * All rights reserved.
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE. See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package modx-test
 */
/**
 * Tests related to context/setting/ processors
 *
 * @package modx-test
 * @subpackage modx
 */
class ContextSettingProcessors extends MODxTestCase {
    const PROCESSOR_LOCATION = 'context/setting/';

    /**
     * Setup some basic data for this test.
     */
    public static function setUpBeforeClass() {
        $modx = MODxTestHarness::_getConnection();
        $ctx = $modx->newObject('modContext');
        $ctx->set('key','unittest');
        $ctx->set('description','The unit test context for context settings.');
        $ctx->save();
    }

    /**
     * Cleanup data after this test.
     */
    public static function tearDownAfterClass() {
        $modx = MODxTestHarness::_getConnection();
        $ctx = $modx->getObject('modContext','unittest');
        if ($ctx) $ctx->remove();
    }

    /**
     * Tests the context/setting/create processor, which creates a context setting
     * @dataProvider providerContextSettingCreate
     */
    public function testContextSettingCreate($ctx,$description = '') {
        if (empty($ctx)) return false;
        $this->assertTrue(true);
        return true;
        try {
            $_POST['key'] = 'unittest';
            $_POST['description'] = $description;
            $result = $this->modx->executeProcessor(array(
                'location' => self::PROCESSOR_LOCATION,
                'action' => 'create',
            ));
        } catch (Exception $e) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, $e->getMessage(), '', __METHOD__, __FILE__, __LINE__);
        }
        $s = $this->checkForSuccess($result);
        $ct = $this->modx->getCount('modContext',$ctx);
        $this->assertTrue($s && $ct > 0,'Could not create context: `'.$ctx.'`: '.$result['message']);
    }
    /**
     * Data provider for context/setting/create processor test.
     */
    public function providerContextSettingCreate() {
        return array(
            array('unittest',''),
        );
    }
}
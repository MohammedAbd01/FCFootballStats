const express = require('express');
const router = express.Router();
const Match = require('../models/Match');

// Get all matches
router.get('/', async (req, res) => {
  try {
    const matches = await Match.find()
      .sort({ date: -1 })
      .populate('events.player', 'name number position');
    res.json(matches);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Get a single match
router.get('/:id', async (req, res) => {
  try {
    const match = await Match.findById(req.params.id)
      .populate('events.player', 'name number position');
    if (!match) {
      return res.status(404).json({ message: 'Match not found' });
    }
    res.json(match);
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Create a new match
router.post('/', async (req, res) => {
  const match = new Match({
    date: req.body.date,
    time: req.body.time,
    opponent: req.body.opponent,
    venue: req.body.venue,
    stats: req.body.stats,
  });

  try {
    const newMatch = await match.save();
    res.status(201).json(newMatch);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

// Update a match
router.put('/:id', async (req, res) => {
  try {
    const match = await Match.findById(req.params.id);
    if (!match) {
      return res.status(404).json({ message: 'Match not found' });
    }

    if (req.body.date) match.date = req.body.date;
    if (req.body.time) match.time = req.body.time;
    if (req.body.opponent) match.opponent = req.body.opponent;
    if (req.body.venue) match.venue = req.body.venue;
    if (req.body.result) match.result = req.body.result;
    if (req.body.status) match.status = req.body.status;
    if (req.body.stats) match.stats = req.body.stats;
    if (req.body.events) match.events = req.body.events;

    const updatedMatch = await match.save();
    res.json(updatedMatch);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

// Delete a match
router.delete('/:id', async (req, res) => {
  try {
    const match = await Match.findById(req.params.id);
    if (!match) {
      return res.status(404).json({ message: 'Match not found' });
    }

    await match.remove();
    res.json({ message: 'Match deleted' });
  } catch (err) {
    res.status(500).json({ message: err.message });
  }
});

// Add an event to a match
router.post('/:id/events', async (req, res) => {
  try {
    const match = await Match.findById(req.params.id);
    if (!match) {
      return res.status(404).json({ message: 'Match not found' });
    }

    match.events.push({
      player: req.body.playerId,
      type: req.body.type,
      minute: req.body.minute,
    });

    const updatedMatch = await match.save();
    res.json(updatedMatch);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

// Remove an event from a match
router.delete('/:id/events/:eventId', async (req, res) => {
  try {
    const match = await Match.findById(req.params.id);
    if (!match) {
      return res.status(404).json({ message: 'Match not found' });
    }

    match.events = match.events.filter(
      event => event._id.toString() !== req.params.eventId
    );

    const updatedMatch = await match.save();
    res.json(updatedMatch);
  } catch (err) {
    res.status(400).json({ message: err.message });
  }
});

module.exports = router; 